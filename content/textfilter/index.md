---
title: "Robins sida"
views:
    kursrepo:
        region: sidebar-right
        template: anax/v2/block/default
        data:
            meta:
                type: single
                route: block/om-kursrepo
    byline:
        region: main
        template: anax/v2/block/default
        sort: 2
        data:
            meta:
                type: single
                route: block/byline
---
Textfilter
=========================
I kmom06 har vi skapat våra egna textfilter som tar en text och parsar den enligt vissa regler, eller filter. Sedan skickas den filtrerade texten tillbaka.

Min klass heter `MyTextFilter` och den ligger under `src/` med namespacet `Blixter/TextFilter`.

Mitt textfilter kan filtrera följande:     
<pre>private $filters = [
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br",
        "escaped"   => "esc"
    ];
</pre>

**[BBcode](filter/bbcode)** används vanligtvis när man skriver foruminlägg. 
T.ex: [b]Tjock text[/b] [i]Italic text[/i] [url=http://dbwebb.se]a länk till dbwebb[/url]

**[Clickable](filter/link)** kan hitta länkar och göra dem klickbara genom att lägga till en `<a href>`.

**[Markdown](filter/markdown)** gör om Markdown kod tilll HTML-kod.

**[Nl2br](filter/nl2br)** kan hitta radbrytningar och lägger till `<br>`.

Till sist går det även att filtrera på escaped vilket anväder `htmlentitites`.