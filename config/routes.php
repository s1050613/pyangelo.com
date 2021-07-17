<?php

return [
  [ 'GET','/', 'HomePageController', 'homePage' ],
  [ 'GET','/about', 'AboutPageController', 'aboutPage' ],
  [ 'GET','/contact', 'ContactPageController', 'contactPage' ],
  [ 'POST','/contact-validate', 'ContactValidateController', 'contactValidate' ],
  [ 'GET','/contact-receipt', 'ContactReceiptController', 'contactReceipt' ],
  [ 'GET','/faq', 'FaqPageController', 'faqPage' ],
  [ 'GET','/privacy-policy', 'PrivacyPolicyController', 'privacyPolicy' ],
  [ 'GET','/terms-of-use', 'TermsController', 'terms' ],
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
  [ 'GET','/canvasonly/[:sketchId]', 'SketchCanvasOnlyController', 'sketchCanvasOnly' ],
  [ 'GET','/sketch/code/[:sketchId]', 'SketchGetCodeController', 'sketchGetCode' ],
  [ 'POST','/sketch/[:sketchId]/fork', 'SketchForkController', 'sketchFork' ],
  [ 'POST','/sketch/[:sketchId]/save', 'SketchSaveController', 'sketchSave' ],
  [ 'POST','/sketch/[:sketchId]/rename', 'SketchRenameController', 'sketchRename' ],
  [ 'POST','/sketch/[:sketchId]/addFile', 'SketchAddFileController', 'sketchAddFile' ],
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
  [ 'GET','/tutorials/[:slug]/lessons/new', 'LessonsNewController', 'lessonsNew' ],
  [ 'POST','/tutorials/[:slug]/lessons/create', 'LessonsCreateController', 'lessonsCreate' ],
  [ 'GET','/tutorials/[:slug]/[:lesson_slug]', 'LessonsShowController', 'lessonsShow' ],
  [ 'GET','/tutorials/[:slug]/lessons/[:lesson_slug]/edit', 'LessonsEditController', 'lessonsEdit' ],
  [ 'POST','/tutorials/[:slug]/lessons/[:lesson_slug]/update', 'LessonsUpdateController', 'lessonsUpdate' ],
  [ 'POST','/get-signed-url', 'LessonsGetSignedUrlController', 'lessonsGetSignedUrl' ],
  [ 'POST','/toggle-lesson-completed', 'LessonsToggleCompletedController', 'lessonsToggleCompleted' ],
  [ 'POST','/toggle-lesson-favourited', 'LessonsToggleFavouritedController', 'lessonsToggleFavourited' ],
  [ 'POST','/toggle-lesson-alert', 'LessonsToggleAlertController', 'lessonsToggleAlert' ],
  [ 'GET','/get-next-video', 'LessonsGetNextVideoController', 'lessonsGetNextVideoUrl' ],
  [ 'POST','/lessons/comment', 'LessonsCommentController', 'lessonsComment' ],
  [ 'POST','/lessons/comment/[:comment_id]/unpublish', 'LessonsCommentUnpublishController', 'lessonsCommentsUnpublish' ],
  [ 'GET','/latest-comments', 'LatestCommentsController', 'latestComments' ],
  [ 'GET','/notifications', 'NotificationsController', 'notifications' ],
  [ 'POST','/notification-read', 'NotificationsReadController', 'notificationsRead' ],
  [ 'POST','/notification-all-read', 'NotificationsAllReadController', 'notificationsAllRead' ],
  [ 'POST','/unsubscribe-thread', 'UnsubscribeThreadController', 'unsubscribeThread' ],
  [ 'GET','/tutorials/[:slug]/lessons/sort', 'LessonsSortController', 'lessonsSort' ],
  [ 'POST','/tutorials/[:slug]/lessons/save-sort-order', 'LessonsOrderController', 'lessonsOrder' ],
  [ 'GET','/blog', 'BlogIndexController', 'blogIndex' ],
  [ 'GET','/blog/new', 'BlogNewController', 'blogNew' ],
  [ 'POST','/blog/create', 'BlogCreateController', 'blogCreate' ],
  [ 'GET','/blog/[:slug]', 'BlogShowController', 'blogShow' ],
  [ 'POST','/toggle-blog-alert', 'BlogToggleAlertController', 'blogToggleAlert' ],
  [ 'POST','/blog/comment', 'BlogCommentController', 'blogComment' ],
  [ 'GET','/blog/[:slug]/edit', 'BlogEditController', 'blogEdit' ],
  [ 'POST','/blog/[:slug]/update', 'BlogUpdateController', 'blogUpdate' ],
  [ 'POST','/blog/comment/[:comment_id]/unpublish', 'BlogCommentUnpublishController', 'blogCommentsUnpublish' ],
  [ 'GET','/favourites', 'FavouritesController', 'favourites' ],
  [ 'GET','/reference', 'ReferenceController', 'reference' ],
  [ 'GET','/asset-library', 'AssetLibraryController', 'assetLibrary' ],
  [ 'GET','/ask-the-teacher', 'AskTheTeacherIndexController', 'askTheTeacherIndex' ],
  [ 'GET','/ask-the-teacher/topic/[:slug]', 'AskTheTeacherCategoryController', 'askTheTeacherCategory' ],
  [ 'GET','/ask-the-teacher/ask', 'AskTheTeacherAskController', 'askTheTeacherAsk' ],
  [ 'POST','/ask-the-teacher/create', 'AskTheTeacherCreateController', 'askTheTeacherCreate' ],
  [ 'GET','/ask-the-teacher/question-list', 'AskTheTeacherQuestionListController', 'askTheTeacherQuestionList' ],
  [ 'GET','/ask-the-teacher/thanks-for-your-question', 'AskTheTeacherThanksController', 'askTheTeacherThanks' ],
  [ 'GET','/ask-the-teacher/my-questions', 'AskTheTeacherMyQuestionsController', 'askTheTeacherMyQuestions' ],
  [ 'GET','/ask-the-teacher/favourite-questions', 'AskTheTeacherFavouriteQuestionsController', 'askTheTeacherFavouriteQuestions' ],
  [ 'GET','/ask-the-teacher/[:slug]', 'AskTheTeacherShowController', 'askTheTeacherShow' ],
  [ 'POST','/ask-the-teacher/[:slug]/delete', 'AskTheTeacherDeleteController', 'askTheTeacherDelete' ],
  [ 'GET','/ask-the-teacher/[:slug]/edit', 'AskTheTeacherEditController', 'askTheTeacherEdit' ],
  [ 'POST','/ask-the-teacher/[:slug]/update', 'AskTheTeacherUpdateController', 'askTheTeacherUpdate' ],
  [ 'POST','/toggle-question-alert', 'AskTheTeacherToggleAlertController', 'askTheTeacherToggleAlert' ],
  [ 'POST','/toggle-question-favourite', 'AskTheTeacherToggleFavouriteController', 'askTheTeacherToggleFavourite' ],
  [ 'POST','/ask-the-teacher/comment', 'AskTheTeacherCommentController', 'askTheTeacherComment' ],
  [ 'POST','/ask-the-teacher/comment/[:comment_id]/unpublish', 'AskTheTeacherCommentUnpublishController', 'askTheTeacherCommentUnpublish' ],
  [ 'GET','/admin', 'MetricsController', 'metrics' ],
  [ 'GET','/admin/users', 'UsersController', 'users' ],
  [ 'GET','/admin/user-search', 'UserSearchController', 'userSearch' ],
  [ 'GET','/admin/users/[:person_id]', 'UserController', 'user' ],
];
