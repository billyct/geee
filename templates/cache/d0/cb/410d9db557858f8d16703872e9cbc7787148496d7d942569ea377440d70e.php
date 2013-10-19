<?php

/* index.html */
class __TwigTemplate_d0cb410d9db557858f8d16703872e9cbc7787148496d7d942569ea377440d70e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!--[if IE 8]>
<html class=\"no-js lt-ie9\">
  <![endif]-->
  <!--[if gt IE 8]>
  <!-->
  <html class=\"no-js\">
    <!--<![endif]-->
<head>
    <meta charset=\"utf-8\">
    <title>geee</title>
    <meta name=\"description\" content=\"geee!\">
    <meta name=\"author\" content=\"billyct\">
    <meta name=\"robots\" content=\"noindex, nofollow\">
    <meta name=\"viewport\" content=\"width=device-width,initial-scale=1,maximum-scale=1.0\">
    <link rel=\"shortcut icon\" href=\"img/favicon.ico\">
    <link rel=\"apple-touch-icon\" href=\"img/apple-touch-icon.png\">
    <link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"img/apple-touch-icon-57x57-precomposed.png\">
    <link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"img/apple-touch-icon-72x72-precomposed.png\">
    <link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"img/apple-touch-icon-114x114-precomposed.png\">
    <link rel=\"apple-touch-icon-precomposed\" href=\"img/apple-touch-icon-precomposed.png\">
    <link rel=\"stylesheet\" href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,800italic,300,400,800'>
    <link rel=\"stylesheet\" href=\"";
        // line 23
        echo twig_escape_filter($this->env, (isset($context["css_path"]) ? $context["css_path"] : null), "html", null, true);
        echo "\">
    <script src=\"js/tmpl/modernizr-2.6.2-respond-1.3.0.min.js\"></script>

</head>


<body class=\"header-fixed-top\" ng-app=\"geee\" ng-controller=\"BaseCtrl\">
  
    <div id=\"sidebar-left\" class=\"enable-hover\" ng-include=\"'/views/layout/sidebar-left.html'\" slideleft>
    </div>

    <div id=\"page-container\" class=\"full-width\">
      <header class=\"navbar navbar-default navbar-fixed-top add-opacity\" ng-include=\"'/views/layout/header.html'\">
        
      </header>
      <div id=\"fx-container\" class=\"fx-opacity\">
        <div id=\"page-content\" class=\"block\" ui-view>
          
        </div>
        <footer class=\"clearfix\">
          <div class=\"pull-right\">
            <i class=\"icon-heart\"></i>
            by
            <a href=\"http://billyct.com\" target=\"_blank\">billyct</a>
          </div>
          <div class=\"pull-left\">
            <span id=\"year-copy\"></span>
            &copy;
            <a href=\"http://billyct.com\" target=\"_blank\">Geelan</a>
          </div>
        </footer>
      </div>
    </div>
    <a href=\"javascript:void(0)\" id=\"to-top\" totop>
      <i class=\"icon-angle-up\"></i>
    </a>


    <script src=\"";
        // line 61
        echo twig_escape_filter($this->env, (isset($context["js_path"]) ? $context["js_path"] : null), "html", null, true);
        echo "\"></script>

</body>
  </html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 61,  43 => 23,  19 => 1,);
    }
}
