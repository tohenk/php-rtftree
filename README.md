PHP RTF Tree
============

PHP Library for RTF processing, port of nrtftree (https://github.com/sgolivernet/nrtftree).

This is work in progress with some additional feature:

* Introduce new white space node type to preserve the original rich text document loaded.
* ReplaceTextEx can replace text which is scattered across nodes.
* Rtf document with measurement unit support (native, mm, cm, inch, pixel).

REQUIREMENT
-----------

* PHP 5.3+

CLASSES
-------

There are 3 main classes for RTF processing.

### NTLAB\RtfTree\Node\Tree

The RTF tree parser, able to parse RTF document into tree nodes, perform selects the nodes
based on keyword, perform search and replace of the plain text, and convert back the nodes
as RTF code.

### NTLAB\RtfTree\Document\Document

RTF tree with additional document entity handler, such as colors, fonts, stylesheets, and
objects.

### NTLAB\RtfTree\Builder\Builder

RTF tree builder.

TODO
----

* Rtf Merger
* Examples
