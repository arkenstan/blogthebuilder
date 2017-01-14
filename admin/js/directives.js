/*
*
* Creator Workspace Directives will Go here
*
*/
(function(){

  var app = angular.module('adminDirectives', []);

/* Creator Navigation */
  app.directive('navbarDashboard', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/navbar_template_dashboard.html'
    };
  });
/* END CREATOR NAVIGATION */


/* Workspace Toolbar Directives */

  app.directive('toolbarDashboard', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/toolbar_template_dashboard.html'
    };
  });
  app.directive('statsToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/toolbar_stats.html'
    };
  });
  app.directive('customizeToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/toolbar_custom.html'
    };
  });
  app.directive('postToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/toolbar_posts.html'
    };
  });

  app.directive('settingsToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/toolbar_settings.html'
    };
  });

/* END TOOLBAR DIRECTIVES */

/*  User workarea Driective */
  app.directive('workarea', function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_workarea.html'
    };
  });
/* END WORKSPACE DIRECTIVE */

/* All View for toolbar Directives */

  app.directive('websiteStats',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_website_stats.html'
    };
  });
  app.directive('activityStats',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_activity_stats.html'
    };
  });
  app.directive('postStats',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_post_stats.html'
    };
  });
  app.directive('trendStats',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_trend_stats.html'
    };
  });
  app.directive('demandStats',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_demand_stats.html'
    };
  });
  app.directive('apperanceCustom',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_appreance_custom.html'
    };
  });
  app.directive('widgetCustom',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_widget_custom.html'
    };
  });
  app.directive('themeCustom',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_theme_custom.html'
    };
  });
  app.directive('pageCustom',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_page_custom.html'
    };
  });
  app.directive('allPost',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_all_post.html'
    };
  });
  app.directive('newPost',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_new_post.html'
    };
  });
  app.directive('categoryPost',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_category_post.html'
    };
  });
  app.directive('mediaPost',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_media_post.html'
    };
  });
  app.directive('commentPost',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_comment_post.html'
    };
  });
  app.directive('tagPost',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_tag_post.html'
    };
  });
  app.directive('generalSetting',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_general_setting.html'
    };
  });
  app.directive('privacySetting',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_privacy_setting.html'
    };
  });
  app.directive('explorerSetting',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_explorer_setting.html'
    };
  });
  app.directive('mediaSetting',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_media_setting.html'
    };
  });
  app.directive('permissionSetting',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_permission_setting.html'
    };
  });
  app.directive('sharingSetting',function(){
    return {
      restrict: 'E',
      templateUrl: './admin/templates/workspace_sharing_setting.html'
    };
  });

/* END VIEW DIRECTIVES */

})();
