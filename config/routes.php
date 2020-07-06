<?php

return [
  [ 'GET','/', 'HomePageController', 'homePage' ],
  [ 'GET','/register', 'RegisterController', 'register' ],
  [ 'POST','/register-validate', 'RegisterValidateController', 'registerValidate' ],
  [ 'GET','/please-confirm-your-registration', 'RegisterConfirmController', 'registerConfirm' ],
  [ 'GET','/activate-free-membership', 'RegisterActivateController', 'registerActivate' ],
  [ 'GET','/thanks-for-registering', 'RegisterThanksController', 'registerThanks' ],
  [ 'GET','/login', 'LoginController', 'login' ],
  [ 'POST','/login-validate', 'LoginValidateController', 'loginValidate' ],
  [ 'POST','/logout', 'LogoutController', 'logout' ],
  [ 'GET','/forgot-password', 'ForgotPasswordController', 'forgotPassword' ],
  [ 'POST','/forgot-password-validate', 'ForgotPasswordValidateController', 'forgotPasswordValidate' ],
  [ 'GET','/forgot-password-confirm', 'ForgotPasswordConfirmController', 'forgotPasswordConfirm' ],
  [ 'GET','/reset-password', 'ResetPasswordController', 'resetPassword' ],
  [ 'POST','/reset-password-validate', 'ResetPasswordValidateController', 'resetPasswordValidate' ],
  [ 'GET','/profile', 'ProfileController', 'profile' ],
  [ 'GET','/password', 'PasswordController', 'password' ],
  [ 'POST','/password-validate', 'PasswordValidateController', 'passwordValidate' ],
  [ 'GET','/newsletter', 'NewsletterController', 'newsletter' ],
  [ 'POST','/newsletter-validate', 'NewsletterValidateController', 'newsletterValidate' ],
  [ 'GET','/sketch', 'SketchIndexController', 'sketchIndex' ],
  [ 'POST','/sketch/create', 'SketchCreateController', 'sketchCreate' ],
  [ 'GET','/sketch/[:sketchId]', 'SketchShowController', 'sketchShow' ],
  [ 'GET','/sketch/code/[:sketchId]', 'SketchGetCodeController', 'sketchGetCode' ],
  [ 'POST','/sketch/[:sketchId]/fork', 'SketchForkController', 'sketchFork' ],
  [ 'POST','/sketch/[:sketchId]/save', 'SketchSaveController', 'sketchSave' ],
  [ 'POST','/sketch/[:sketchId]/rename', 'SketchRenameController', 'sketchRename' ],
  [ 'POST','/sketch/[:sketchId]/addFile', 'SketchAddFileController', 'sketchAddFile' ],
  [ 'GET','/run/[:sketchId]', 'SketchRunController', 'sketchRun' ],
  [ 'GET','/present/[:sketchId]', 'SketchPresentController', 'sketchPresent' ],
  [ 'POST','/upload/asset', 'UploadAssetController', 'uploadAsset' ],
  [ 'GET','/categories/[:slug]', 'CategoriesShowController', 'categoriesShow' ],
  [ 'GET','/categories/[:slug]/sort', 'CategoriesSortController', 'categoriesSort' ],
  [ 'POST','/categories/[:slug]/save-sort-order', 'CategoriesOrderController', 'categoriesOrder' ],
  [ 'GET','/tutorials', 'TutorialsIndexController', 'tutorialsIndex' ],
  [ 'GET','/tutorials/new', 'TutorialsNewController', 'tutorialsNew' ],
  [ 'POST','/tutorials/create', 'TutorialsCreateController', 'tutorialsCreate' ],
  [ 'GET','/tutorials/[:slug]', 'TutorialsShowController', 'tutorialsShow' ],
  [ 'GET','/tutorials/[:slug]/edit', 'TutorialsEditController', 'tutorialsEdit' ],
  [ 'POST','/tutorials/[:slug]/update', 'TutorialsUpdateController', 'tutorialsUpdate' ],
];
