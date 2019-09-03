Styleguide and Documentation website tool
==========

The tool is pretty simple. It just displays snippets of html styled to the the website styling. It collects these snippits and displays them by category in the main menu. It makes it easier to present and document design patterns.

The overall goal is make the frontend architecture have uniformity and make html more modular. Using this philosophy, it should be possible to pull a section (block) off the homepage, and have it appear exactly the same on any page of the site.

====

This site is powered by Codeignitor 2.2.
It uses a number of components borrowed from the Styleguide Biolerplate Project (MIT License https://github.com/bjankord/Style-Guide-Boilerplate/blob/master/LICENSE.txt )

Features:

    login/logout
    create/edit/delete Docs across two categories.
    create/edit/delete Patterns across five categories.
    WYSIWYG customized for Bootstrap powered by CKeditor.
    HTML for Patterns editable with the Ace editor.
    Basic page caching for extra speedy pages
    Styling is namespaced to seperate from it from the Less files.
    Less is processed to Css using Grunt
