# Referrer Keywords

This plugin is to be used in conjunction with ExpressionEngine's first party Referrer module. You could just do this:

{exp:referrer limit="1"}{ref_from}{/exp:referrer}

but because the module automatically outputs {ref_from} with an anchor tag wrapped around it, if you try to use that in a hidden form input in a contact form, it'll break your page.

So this plugin just strips out the unnecessary HTML and returns a string including the referrer and the keywords (if the referrer is a search engine).

Place {exp:referrer limit="1"}{exp:referrer_keywords}{ref_from}{/exp:referrer_keywords}{/exp:referrer} somewhere in your template.

## Changelog

### 1.0.0
--------------------
Initial public release