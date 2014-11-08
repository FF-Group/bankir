<?php

/* macros_edit.html.twig */
class __TwigTemplate_1d2f2724d164aec839baf0dce11ae430 extends Twig_Template
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
        // line 7
        echo "
";
        // line 62
        echo "
";
    }

    // line 9
    public function getfarbtastic_script($_id = null)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $_id,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 10
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            if ((!twig_test_empty($_id_))) {
                // line 11
                echo "    ";
                if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
                $context["id"] = ($_id_ . "_");
            }
            // line 12
            echo " 
<script type=\"text/javascript\">
/*<![CDATA[*/
";
            // line 58
            echo "(function(a){myatu_bgm_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color={showHideClear:function(){var b=a(\"#background_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\").val();if(b&&b.charAt(0)==\"#\"){if(b.length>1){a(\"#clear_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\").show()}else{a(\"#clear_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\").hide()}}}};a(document).ready(function(c){var b=\"#myatu_bg_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color_picker\",d=\"#background_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\";c(b).farbtastic(function(e){c(d).attr(\"value\",e)});c.farbtastic(b).setColor(c(d).val());c(d).focusin(function(){c(b).show()}).focusout(function(){c(b).hide();myatu_bgm_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color.showHideClear()}).keyup(function(){if(this.value.charAt(0)!=\"#\"){this.value=\"#\"+this.value}c.farbtastic(b).setColor(c(d).val())});c(\"#clear_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\").click(function(){c(d).val(\"#\");myatu_bgm_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color.showHideClear()});myatu_bgm_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color.showHideClear()})})(jQuery);
/*]]>*/
</script>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 64
    public function getfarbtastic_input($_id = null, $_value = null)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $_id,
            "value" => $_value,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 65
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            if ((!twig_test_empty($_id_))) {
                // line 66
                echo "    ";
                if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
                $context["id"] = ($_id_ . "_");
            }
            // line 67
            echo " 
<input type=\"text\" value=\"#";
            // line 68
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            echo twig_escape_filter($this->env, $_value_, "html", null, true);
            echo "\" autocomplete=\"off\" name=\"background_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\" id=\"background_";
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\" />
<input type=\"button\" id=\"clear_";
            // line 69
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color\" class=\"hide-if-no-js button\" value=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('translate')->transFilter("Clear"), "html", null, true);
            echo "\" />
<div id=\"myatu_bg_";
            // line 70
            if (isset($context["id"])) { $_id_ = $context["id"]; } else { $_id_ = null; }
            echo twig_escape_filter($this->env, $_id_, "html", null, true);
            echo "color_picker\" class=\"hide-if-no-js\" style=\"z-index:100;background:#eeeeee;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:1px solid #ccc;position:absolute;display:none;padding:2px;box-shadow:5px 5px 5px #AAA;-moz-box-shadow:5px 5px 5px #AAA;-webkit-box-shadow:5px 5px 5px #AAA;\"></div>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "macros_edit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  136 => 70,  129 => 69,  118 => 68,  110 => 66,  107 => 65,  95 => 64,  51 => 58,  46 => 12,  41 => 11,  38 => 10,  190 => 47,  184 => 43,  166 => 41,  161 => 40,  152 => 36,  146 => 33,  139 => 28,  120 => 24,  115 => 67,  104 => 22,  86 => 21,  83 => 20,  55 => 18,  29 => 12,  22 => 62,  88 => 35,  85 => 34,  72 => 31,  69 => 30,  66 => 29,  57 => 24,  53 => 23,  50 => 22,  40 => 18,  36 => 16,  26 => 12,  39 => 14,  28 => 11,  24 => 9,  37 => 17,  33 => 15,  27 => 9,  23 => 9,  19 => 7,);
    }
}
