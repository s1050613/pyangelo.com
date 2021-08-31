let editorSession = 0;
let currentSession = 0;
let currentFilename = "main.py";
let editor = ace.edit("editor");
// Set up function to listen for resize
const onresize = (dom_elem, callback) => {
  const resizeObserver = new ResizeObserver(() => callback() );
  resizeObserver.observe(dom_elem);
};
editorWindow = document.getElementById("editor");
onresize(editorWindow, function () {
  editor.resize();
});

editor.$blockScrolling = Infinity;
ace.config.set("basePath", "https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/");
editor.setTheme("ace/theme/dracula");

var UndoManager = ace.require("ace/undomanager").UndoManager;

var PythonMode = ace.require("ace/mode/python").Mode;
let langTools = ace.require("ace/ext/language_tools");
var staticWordCompleter = {
    getCompletions: function(editor, session, pos, prefix, callback) {
        var wordList = [
          "setCanvasSize",
          "noCanvas",
          "focusCanvas",
          "rect",
          "circle",
          "ellipse",
          "arc",
          "line",
          "point",
          "triangle",
          "quad",
          "rectMode",
          "circleMode",
          "strokeWeight",
          "beginShape",
          "vertex",
          "endShape",
          "background",
          "fill",
          "noFill",
          "stroke",
          "noStroke",
          "isKeyPressed",
          "wasKeyPressed",
          "text",
          "loadImage",
          "image",
          "angleMode",
          "translate",
          "rotate",
          "applyMatrix",
          "shearX",
          "shearY",
          "saveState",
          "restoreState",
          "setConsoleSize",
          "setTextColour",
          "setHighlightColour",
          "clear",
          "sleep",
          "loadSound",
          "playSound",
          "stopSound",
          "pauseSound",
          "stopAllSounds",
          "width",
          "height",
          "mouseX",
          "mouseY",
          "dist",
          "Sprite",
          "TextSprite",
          "RectangleSprite",
          "CircleSprite",
          "EllipseSprite",
        ];
        callback(null, [...wordList.map(function(word) {
            return {
                caption: word,
                value: word,
                meta: "static"
            };
        }), ...session.$mode.$highlightRules.$keywordList.map(function(word) {
        return {
          caption: word,
          value: word,
          meta: 'keyword',
        };
      })]);

    }
}

langTools.setCompleters([staticWordCompleter])
// or
editor.completers = [staticWordCompleter]
var EditSession = require("ace/edit_session").EditSession;
var editSessions = [];

function getCode(session) {
  return editSessions[session].getValue();
}
function saveCode(filename) {
  let code = getCode(currentSession);
  if (filename !== "main.py") {
    Sk.builtinFiles.files["./" + filename] = code;
  }

  const crsfToken = document.getElementById('editor').getAttribute('data-crsf-token');
  const data = "filename=" + encodeURIComponent(filename) + "&program=" + encodeURIComponent(code) + "&crsfToken=" + encodeURIComponent(crsfToken);
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: data
  };
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  fetch('/sketch/' + sketchId + '/save', options)
    .then(response => response.json())
    .then(data => { console.log(data); });
}
function loadCode() {
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  fetch('/sketch/code/' + sketchId)
    .then(response => response.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message);
      }
      setupEditor(data);
    })
    .catch(error => { console.error(error); })
}
function loadCodeAndRun() {
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  fetch('/sketch/code/' + sketchId)
    .then(response => response.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message);
      }
      setupEditor(data);
    })
    .then(runCode)
    .catch(error => { console.error(error); })
}
function setupEditor(data) {
  data.files.forEach(addTab);
  editor.setSession(editSessions[currentSession]);
}
function addTab(file) {
    const readOnly = document.getElementById('editor').getAttribute('data-read-only');
  
    let span = document.createElement('span');
    span.dataset.filename = file.filename;
    let text = document.createTextNode(file.filename);
    span.appendChild(text);
    if (file.filename !== "main.py" && readOnly == false) {
      let deleteButton = document.createElement('span');
      deleteButton.innerHTML = '&times;';
      deleteButton.onclick = function(ev) {
        ev.stopPropagation();
        if (confirm('Are you sure you want to delete ' + file.filename + '? This operation cannot be undone!')) {
          if (currentFilename == file.filename) {
            currentSession = 0;
            document.querySelector(".editorTab[data-filename='main.py']").classList.add("current");
            editor.setSession(editSessions[currentSession]);
          }
          deleteFile(file.filename);
          delete Sk.builtinFiles.files["./" + file.filename];
        }
      };
      deleteButton.classList.add('smallButton');
      span.appendChild(deleteButton);
    }
    span.classList.add("editorTab");
    if (file.filename === "main.py") {
      span.classList.add("current");
    }
    fileTabs = document.getElementById('fileTabs');

    if (file.filename.endsWith(".py")) {
      if (!file.sourceCode) {
        file.sourceCode = "";
      }
      if (file.filename !== "main.py") {
          Sk.builtinFiles.files["./" + file.filename] = file.sourceCode;
      }
      editSessions.push(new EditSession(file.sourceCode));
      editSessions[editorSession].setMode(new PythonMode());
      editSessions[editorSession].setUndoManager(new UndoManager());
      if (readOnly == true) {
        editor.setOptions({
            readOnly: true,
            fontSize: "12pt",
            enableBasicAutocompletion: true,
            enableSnippets: false,
            enableLiveAutocompletion: true,
        });
      }
      else {
        editor.setOptions({
            readOnly: false,
            fontSize: "12pt",
            enableBasicAutocompletion: true,
            enableSnippets: false,
            enableLiveAutocompletion: true,
        });
      }

      span.setAttribute("data-editor-session", editorSession);
      span.setAttribute("data-filename", file.filename);
      span.onclick=loadSession;
      editorSession++;
    }
    fileTabs.appendChild(span);
}
function loadSession(ev) {
  saveCode(currentFilename);
  currentFilename = ev.target.getAttribute("data-filename");
  currentSession = ev.target.getAttribute("data-editor-session");
  editor.setSession(editSessions[currentSession]);
  document.querySelector(".editorTab.current").classList.remove("current");
  ev.target.classList.add("current");
}
function newPythonFile() {
  const moduleNames = [
    '_abcoll',
    'abc',
    'aifc',
    'antigravity',
    'anydbm',
    'array',
    'ast',
    'asynchat',
    'asyncore',
    'atexit',
    'audiodev',
    'base64',
    'BaseHTTPServer',
    'Bastion',
    'bdb',
    'binhex',
    'bisect',
    'bsddb',
    'calendar',
    'CGIHTTPServer',
    'cgi',
    'cgitb',
    'chunk',
    'cmd',
    'codecs',
    'codeop',
    'code',
    'collections',
    'colorsys',
    'commands',
    'compileall',
    'compiler',
    'config',
    'ConfigParser',
    'contextlib',
    'cookielib',
    'Cookie',
    'copy',
    'copy_reg',
    'cProfile',
    'csv',
    'ctypes',
    'curses',
    'datetime',
    'dbhash',
    'decimal',
    'difflib',
    'dircache',
    'dis',
    'distutils',
    'doctest',
    'document',
    'DocXMLRPCServer',
    'dumbdbm',
    'dummy_threading',
    'dummy_thread',
    'email',
    'encodings',
    'filecmp',
    'fileinput',
    'fnmatch',
    'formatter',
    'fpformat',
    'fractions',
    'ftplib',
    'functools',
    '__future__',
    'genericpath',
    'getopt',
    'getpass',
    'gettext',
    'glob',
    'gzip',
    'hashlib',
    'heapq',
    'hmac',
    'hotshot',
    'htmlentitydefs',
    'htmllib',
    'HTMLParser',
    'httplib',
    'idlelib',
    'ihooks',
    'image',
    'imaplib',
    'imghdr',
    'imputil',
    'io',
    'itertools',
    'json',
    'keyword',
    'lib2to3',
    'lib-dynload',
    'lib-tk',
    'linecache',
    'locale',
    'logging',
    '_LWPCookieJar',
    'macpath',
    'macurl2path',
    'mailbox',
    'mailcap',
    'markupbase',
    'math',
    'md5',
    'mhlib',
    'mimetools',
    'mimetypes',
    'MimeWriter',
    'mimify',
    'modulefinder',
    '_MozillaCookieJar',
    'multifile',
    'multiprocessing',
    'mutex',
    'netrc',
    'new',
    'nntplib',
    'ntpath',
    'nturl2path',
    'numbers',
    'opcode',
    'operator',
    'optparse',
    'os2emxpath',
    'os',
    'pdb',
    '__phello__.foo',
    'pickle',
    'pickletools',
    'pipes',
    'pkgutil',
    'platform',
    'platform',
    'plistlib',
    'popen2',
    'poplib',
    'posixfile',
    'posixpath',
    'pprint',
    'processing',
    'profile',
    'pstats',
    'pty',
    'pyclbr',
    'py_compile',
    'pydoc',
    'pydoc_topics',
    'pythonds',
    'Queue',
    'quopri',
    'random',
    're',
    'repr',
    'rexec',
    'rfc822',
    'rlcompleter',
    'robotparser',
    'runpy',
    'sched',
    'sets',
    'sgmllib',
    'sha',
    'shelve',
    'shlex',
    'shutil',
    'signal',
    'SimpleHTTPServer',
    'SimpleXMLRPCServer',
    'site',
    'smtpd',
    'smtplib',
    'sndhdr',
    'socket',
    'SocketServer',
    'sprite',
    'sqlite3',
    'sre_compile',
    'sre_constants',
    'sre_parse',
    'sre',
    'ssl',
    'stat',
    'statvfs',
    'StringIO',
    'string',
    'stringold',
    'stringprep',
    '_strptime',
    'struct',
    'subprocess',
    'sunaudio',
    'sunau',
    'symbol',
    'symtable',
    'tabnanny',
    'tarfile',
    'telnetlib',
    'tempfile',
    'test',
    'textwrap',
    'this',
    '_threading_local',
    'threading',
    'timeit',
    'time',
    'toaiff',
    'tokenize',
    'token',
    'traceback',
    'trace',
    'tty',
    'turtle',
    'types',
    'unittest',
    'urllib',
    'urllib2',
    'urlparse',
    'UserDict',
    'UserList',
    'user',
    'UserString',
    'uuid',
    'uu',
    'warnings',
    'wave',
    'weakref',
    'webbrowser',
    'webgl',
    'whichdb',
    'wsgiref',
    'xdrlib',
    'xml',
    'xmllib',
    'xmlrpclib',
    'zipfile',
  ];
  let filename = window.prompt("Enter the new filename: ");
  if (!filename.endsWith(".py")) {
    alert("The filename must end with .py");
    return;
  }
  if (filename === "main.py") {
    alert("You cannot create a second main.py. Please choose a different name for your file");
    return;
  }
  const moduleName = filename.substr(0, filename.lastIndexOf("."));
  if (moduleNames.includes(moduleName)) {
    alert(moduleName + " is a system module. Please choose a different name for your file");
    return;
  }
  // Check file not already created for this sketch
  if (Sk.builtinFiles.files["./" + filename] !== undefined) {
    alert("You have already created a file called " + filename + " for this sketch.");
    return;
  }
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  const crsfToken = document.getElementById('editor').getAttribute('data-crsf-token');
  const data = "filename=" + encodeURIComponent(filename) + "&sketchId=" + encodeURIComponent(sketchId) + "&crsfToken=" + encodeURIComponent(crsfToken);
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: data
  };
  fetch('/sketch/' + sketchId +'/addFile', options)
    .then(response => response.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message);
      }
      addNewFile(data);
    })
    .catch(error => { console.error(error); });
}
function addNewFile(data) {
  let file = { "filename": data.filename, "sourceCode": "" };
  addTab(file);
}
function deleteFile(filename) {
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  const crsfToken = document.getElementById('editor').getAttribute('data-crsf-token');
  const data = "filename=" + encodeURIComponent(filename) + "&sketchId=" + encodeURIComponent(sketchId) + "&crsfToken=" + encodeURIComponent(crsfToken);
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: data
  };
  fetch('/sketch/' + sketchId + '/deleteFile', options)
    .then(response => response.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message);
      }
      deleteOldFile(data);
    })
    .catch(error => { console.error(error); })
}
function deleteOldFile(data) {
  let span = document.querySelector(`.editorTab[data-filename='${data.filename}']`);
  if(!span) {
    alert("An unknown error occured; please try again or contact us.");
    return;
  }
  span.remove();
}
function showRename(event) {
  event.preventDefault();
  document.getElementById('rename-form').style.display = "block";
  document.getElementById('title').style.display = "none";
}
function cancelRename(event) {
  event.preventDefault();
  document.getElementById('rename-form').style.display = "none";
  document.getElementById('title').style.display = "block";
}
function submitRename(event) {
  event.preventDefault();
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  const crsfToken = document.getElementById('editor').getAttribute('data-crsf-token');
  const data = "newTitle=" + document.getElementById('newTitle').value + "&sketchId=" + encodeURIComponent(sketchId) + "&crsfToken=" + encodeURIComponent(crsfToken);
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: data
  };
  fetch('/sketch/' + sketchId +'/rename', options)
    .then(response => response.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message);
      }
      updateTitle(data);
    })
    .catch((error) => { console.error(error); })
}
function updateTitle(data) {
  const sketchId = document.getElementById('editor').getAttribute('data-sketch-id');
  document.getElementById('rename-form').style.display = "none";
  const innerHTML = '<a id="rename" href="/sketch/' + sketchId + '/rename" onclick="showRename(event)">' + data.title + ' <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
  document.getElementById('title').innerHTML = innerHTML;
  document.getElementById('title').style.display = "block";
  document.title = data.title;
}

function saveThenRun() {
  saveCode(currentFilename);
  runCode();
}
function runCode() {
  const startStopButton = document.getElementById('startStop');
  startStopButton.removeEventListener('click', saveThenRun, false);
  startStopButton.style.backgroundColor = '#880000';
  startStopButton.textContent = 'Stop';
  startStopButton.addEventListener('click', saveThenStop, false);
  document.getElementById("console").innerHTML = '';
  _stopExecution = false;
  runSkulpt(getCode(0));
}
function saveThenStop() {
  saveCode(currentFilename);
  stopCode();
}
function stopCode() {
  _stopExecution = true;
  Sk.builtin.stopAllSounds();
  const startStopButton = document.getElementById('startStop');
  startStopButton.removeEventListener('click', saveThenStop, false);
  startStopButton.style.backgroundColor = '#008800';
  startStopButton.textContent = 'Start';
  startStopButton.addEventListener('click', saveThenRun, false);
}

document.getElementById('startStop').addEventListener('click', saveThenRun, false);
