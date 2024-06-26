
<!DOCTYPE html>
<html>
<head>
    <title>jQuery UI Bootstrap</title>
    <meta charset="UTF-8" />

    <link rel="stylesheet" type="text/css" href="support/styles/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="support/styles/jquery.ui.base.css" />
    <link rel="stylesheet" type="text/css" href="support/styles/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="theme/jquery.ui.theme.css" />
    <link rel="stylesheet" type="text/css" href="theme/jquery.ui.theme.font-awesome.css" />

    <style type="text/css">
        body { padding-bottom: 40px; }

        .widget .page-header { margin-bottom: 15px; }
        .widget .page-header .ui-icon { vertical-align: middle; }
        #icons { cursor: default; }
        #icons li { padding: 3px; margin-bottom: 3px; }

        .state { margin-bottom: 10px; }
        .state .ui-icon { float: left; margin: 2px 3px 0 0; }

        .ui-progressbar {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
<div class="hero-unit">
    <div class="container">
        <h1>jQuery UI Bootstrap theme</h1>
        <h3>The incredible styles of Twitter Bootstrap, now for jQuery UI!</h3>
    </div>
</div>

<div class="container">
    <div class="well">
        <h4>Welcome to the jQuery UI Bootstrap theme!</h4>
        <p>
            I'm <a href="https://github.com/gustavohenke" title="My GitHub profile">Gustavo Henke</a>,
            and this is the demo page for my try at styling <a href="http://jqueryui.com" title="jQuery UI">jQuery UI</a> just like
            <a href="http://getbootstrap.com" title="Twitter Bootstrap">Twitter Bootstrap</a>.<br />
            You can install it with ease via <a href="http://twitter.github.com/bower/">Bower</a>:
        </p>
        <p><code>bower install jquery-ui-bootstrap</code></p>
        <p>Optionally, you can also simply <a href="https://github.com/gustavohenke/jquery-ui-bootstrap/archive/master.zip">download jQuery UI Bootstrap theme</a>.</p>
        <h5>Why?</h5>
        <p>
            I knew about <a href="https://github.com/addyosmani/" title="Addy Osmani's GitHub profile">Addy Osmani</a>'s try with this before
            starting my own repository. However, he looks compromised with other things, and his styles are outdated. So, I asked myself: <em>why
                not try it?</em> It would be incredible to make it happen for Bootstrap 2!<br />
            I hope you enjoy my work!
        </p>
        <iframe src="http://ghbtns.com/github-btn.html?user=gustavohenke&amp;repo=jquery-ui-bootstrap&amp;type=watch&amp;count=true"
                style="width:110px;height:20px;border:0"></iframe>
        <iframe src="http://ghbtns.com/github-btn.html?user=gustavohenke&amp;repo=jquery-ui-bootstrap&amp;type=fork&amp;count=true"
                style="width:95px;height:20px;border:0"></iframe>
        <iframe src="http://ghbtns.com/github-btn.html?user=gustavohenke&amp;type=follow&amp;count=true"
                style="width:165px;height:20px;border:0"></iframe>
    </div>
    <div class="row">
        <div class="span8">
            <!--Accordion-->
            <div class="widget">
                <h4 class="page-header">Accordion</h4>
                <div id="accordion">
                    <h3>First Header</h3>
                    <div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium hendrerit mollis. Duis quis felis ut tellus imperdiet pretium.
                        Proin non urna felis, vel aliquet lacus. Praesent ac risus arcu, at volutpat dolor. Ut at nisl in libero condimentum interdum in et sapien.
                        Nulla ut velit gravida lorem ultrices varius ut quis dolor. Integer quis urna nec ipsum mollis aliquet. Cras aliquam tincidunt cursus.
                    </div>

                    <h3>Second Header</h3>
                    <div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium hendrerit mollis. Duis quis felis ut tellus imperdiet pretium.
                        Proin non urna felis, vel aliquet lacus. Praesent ac risus arcu, at volutpat dolor. Ut at nisl in libero condimentum interdum in et sapien.
                        Nulla ut velit gravida lorem ultrices varius ut quis dolor. Integer quis urna nec ipsum mollis aliquet. Cras aliquam tincidunt cursus.
                    </div>

                    <h3>Third Header</h3>
                    <div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium hendrerit mollis. Duis quis felis ut tellus imperdiet pretium.
                        Proin non urna felis, vel aliquet lacus. Praesent ac risus arcu, at volutpat dolor. Ut at nisl in libero condimentum interdum in et sapien.
                        Nulla ut velit gravida lorem ultrices varius ut quis dolor. Integer quis urna nec ipsum mollis aliquet. Cras aliquam tincidunt cursus.
                    </div>
                </div>
            </div>

            <!--Tabs-->
            <div class="widget">
                <h4 class="page-header">Tabs</h4>
                <div id="tabs">
                    <ul>
                        <li><a href="#tab1">Tab 1</a></li>
                        <li><a href="#tab2">Tab 2</a></li>
                        <li><a href="#tab3">Tab 3</a></li>
                    </ul>
                    <div id="tab1">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium hendrerit mollis. Duis quis felis ut tellus imperdiet pretium.
                        Proin non urna felis, vel aliquet lacus. Praesent ac risus arcu, at volutpat dolor. Ut at nisl in libero condimentum interdum in et sapien.
                        Nulla ut velit gravida lorem ultrices varius ut quis dolor. Integer quis urna nec ipsum mollis aliquet. Cras aliquam tincidunt cursus.
                    </div>

                    <div id="tab2">
                        This is the second tab!
                    </div>

                    <div id="tab3">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium hendrerit mollis. Duis quis felis ut tellus imperdiet pretium.
                    </div>
                </div>
            </div>

            <!--Dialog-->
            <div class="widget">
                <h4 class="page-header">Dialog</h4>
                <button id="open-dialog">Open the dialog</button>
                <div id="dialog">
                    <p>This is the content of the dialog!</p>
                    <p>Why not drag it around or resize it?</p>
                </div>
            </div>

            <!--Framework icons-->
            <div class="widget">
                <h4 class="page-header">
                    <span class="ui-icon ui-icon-lightbulb ui-icon-inline" title="Hover each icon to find his class name"></span>
                    Framework icons
                    <small style="font-size:.7em"><a href="javascript:;" class="fontawesome-toggle">Toggle FontAwesome icons</a></small>
                </h4>
                <ul id="icons" class="ui-widget ui-helper-clearfix unstyled inline">

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-n"><span class="ui-icon ui-icon-carat-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-ne"><span class="ui-icon ui-icon-carat-1-ne"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-e"><span class="ui-icon ui-icon-carat-1-e"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-se"><span class="ui-icon ui-icon-carat-1-se"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-s"><span class="ui-icon ui-icon-carat-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-sw"><span class="ui-icon ui-icon-carat-1-sw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-w"><span class="ui-icon ui-icon-carat-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-1-nw"><span class="ui-icon ui-icon-carat-1-nw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-2-n-s"><span class="ui-icon ui-icon-carat-2-n-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-carat-2-e-w"><span class="ui-icon ui-icon-carat-2-e-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-n"><span class="ui-icon ui-icon-triangle-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-ne"><span class="ui-icon ui-icon-triangle-1-ne"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-e"><span class="ui-icon ui-icon-triangle-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-se"><span class="ui-icon ui-icon-triangle-1-se"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-s"><span class="ui-icon ui-icon-triangle-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-sw"><span class="ui-icon ui-icon-triangle-1-sw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-w"><span class="ui-icon ui-icon-triangle-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-1-nw"><span class="ui-icon ui-icon-triangle-1-nw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-2-n-s"><span class="ui-icon ui-icon-triangle-2-n-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-triangle-2-e-w"><span class="ui-icon ui-icon-triangle-2-e-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-n"><span class="ui-icon ui-icon-arrow-1-n"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-ne"><span class="ui-icon ui-icon-arrow-1-ne"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-e"><span class="ui-icon ui-icon-arrow-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-se"><span class="ui-icon ui-icon-arrow-1-se"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-s"><span class="ui-icon ui-icon-arrow-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-sw"><span class="ui-icon ui-icon-arrow-1-sw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-w"><span class="ui-icon ui-icon-arrow-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-1-nw"><span class="ui-icon ui-icon-arrow-1-nw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-2-n-s"><span class="ui-icon ui-icon-arrow-2-n-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-2-ne-sw"><span class="ui-icon ui-icon-arrow-2-ne-sw"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-2-e-w"><span class="ui-icon ui-icon-arrow-2-e-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-2-se-nw"><span class="ui-icon ui-icon-arrow-2-se-nw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowstop-1-n"><span class="ui-icon ui-icon-arrowstop-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowstop-1-e"><span class="ui-icon ui-icon-arrowstop-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowstop-1-s"><span class="ui-icon ui-icon-arrowstop-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowstop-1-w"><span class="ui-icon ui-icon-arrowstop-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-n"><span class="ui-icon ui-icon-arrowthick-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-ne"><span class="ui-icon ui-icon-arrowthick-1-ne"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-e"><span class="ui-icon ui-icon-arrowthick-1-e"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-se"><span class="ui-icon ui-icon-arrowthick-1-se"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-s"><span class="ui-icon ui-icon-arrowthick-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-sw"><span class="ui-icon ui-icon-arrowthick-1-sw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-w"><span class="ui-icon ui-icon-arrowthick-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-1-nw"><span class="ui-icon ui-icon-arrowthick-1-nw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-2-n-s"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-2-ne-sw"><span class="ui-icon ui-icon-arrowthick-2-ne-sw"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-2-e-w"><span class="ui-icon ui-icon-arrowthick-2-e-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthick-2-se-nw"><span class="ui-icon ui-icon-arrowthick-2-se-nw"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthickstop-1-n"><span class="ui-icon ui-icon-arrowthickstop-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthickstop-1-e"><span class="ui-icon ui-icon-arrowthickstop-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthickstop-1-s"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowthickstop-1-w"><span class="ui-icon ui-icon-arrowthickstop-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturnthick-1-w"><span class="ui-icon ui-icon-arrowreturnthick-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturnthick-1-n"><span class="ui-icon ui-icon-arrowreturnthick-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturnthick-1-e"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturnthick-1-s"><span class="ui-icon ui-icon-arrowreturnthick-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturn-1-w"><span class="ui-icon ui-icon-arrowreturn-1-w"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturn-1-n"><span class="ui-icon ui-icon-arrowreturn-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturn-1-e"><span class="ui-icon ui-icon-arrowreturn-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowreturn-1-s"><span class="ui-icon ui-icon-arrowreturn-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowrefresh-1-w"><span class="ui-icon ui-icon-arrowrefresh-1-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowrefresh-1-n"><span class="ui-icon ui-icon-arrowrefresh-1-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowrefresh-1-e"><span class="ui-icon ui-icon-arrowrefresh-1-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrowrefresh-1-s"><span class="ui-icon ui-icon-arrowrefresh-1-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-4"><span class="ui-icon ui-icon-arrow-4"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-arrow-4-diag"><span class="ui-icon ui-icon-arrow-4-diag"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-extlink"><span class="ui-icon ui-icon-extlink"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-newwin"><span class="ui-icon ui-icon-newwin"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-refresh"><span class="ui-icon ui-icon-refresh"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-shuffle"><span class="ui-icon ui-icon-shuffle"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-transfer-e-w"><span class="ui-icon ui-icon-transfer-e-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-transferthick-e-w"><span class="ui-icon ui-icon-transferthick-e-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-folder-collapsed"><span class="ui-icon ui-icon-folder-collapsed"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-folder-open"><span class="ui-icon ui-icon-folder-open"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-document"><span class="ui-icon ui-icon-document"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-document-b"><span class="ui-icon ui-icon-document-b"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-note"><span class="ui-icon ui-icon-note"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-mail-closed"><span class="ui-icon ui-icon-mail-closed"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-mail-open"><span class="ui-icon ui-icon-mail-open"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-suitcase"><span class="ui-icon ui-icon-suitcase"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-comment"><span class="ui-icon ui-icon-comment"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-person"><span class="ui-icon ui-icon-person"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-print"><span class="ui-icon ui-icon-print"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-trash"><span class="ui-icon ui-icon-trash"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-locked"><span class="ui-icon ui-icon-locked"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-unlocked"><span class="ui-icon ui-icon-unlocked"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-bookmark"><span class="ui-icon ui-icon-bookmark"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-tag"><span class="ui-icon ui-icon-tag"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-home"><span class="ui-icon ui-icon-home"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-flag"><span class="ui-icon ui-icon-flag"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-calculator"><span class="ui-icon ui-icon-calculator"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-cart"><span class="ui-icon ui-icon-cart"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-pencil"><span class="ui-icon ui-icon-pencil"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-clock"><span class="ui-icon ui-icon-clock"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-disk"><span class="ui-icon ui-icon-disk"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-calendar"><span class="ui-icon ui-icon-calendar"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-zoomin"><span class="ui-icon ui-icon-zoomin"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-zoomout"><span class="ui-icon ui-icon-zoomout"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-search"><span class="ui-icon ui-icon-search"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-wrench"><span class="ui-icon ui-icon-wrench"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-gear"><span class="ui-icon ui-icon-gear"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-heart"><span class="ui-icon ui-icon-heart"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-star"><span class="ui-icon ui-icon-star"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-link"><span class="ui-icon ui-icon-link"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-cancel"><span class="ui-icon ui-icon-cancel"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-plus"><span class="ui-icon ui-icon-plus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-plusthick"><span class="ui-icon ui-icon-plusthick"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-minus"><span class="ui-icon ui-icon-minus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-minusthick"><span class="ui-icon ui-icon-minusthick"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-close"><span class="ui-icon ui-icon-close"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-closethick"><span class="ui-icon ui-icon-closethick"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-key"><span class="ui-icon ui-icon-key"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-lightbulb"><span class="ui-icon ui-icon-lightbulb"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-scissors"><span class="ui-icon ui-icon-scissors"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-clipboard"><span class="ui-icon ui-icon-clipboard"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-copy"><span class="ui-icon ui-icon-copy"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-contact"><span class="ui-icon ui-icon-contact"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-image"><span class="ui-icon ui-icon-image"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-video"><span class="ui-icon ui-icon-video"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-script"><span class="ui-icon ui-icon-script"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-alert"><span class="ui-icon ui-icon-alert"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-info"><span class="ui-icon ui-icon-info"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-notice"><span class="ui-icon ui-icon-notice"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-help"><span class="ui-icon ui-icon-help"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-check"><span class="ui-icon ui-icon-check"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-bullet"><span class="ui-icon ui-icon-bullet"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-radio-off"><span class="ui-icon ui-icon-radio-off"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-radio-on"><span class="ui-icon ui-icon-radio-on"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-pin-w"><span class="ui-icon ui-icon-pin-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-pin-s"><span class="ui-icon ui-icon-pin-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-play"><span class="ui-icon ui-icon-play"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-pause"><span class="ui-icon ui-icon-pause"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-seek-next"><span class="ui-icon ui-icon-seek-next"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-seek-prev"><span class="ui-icon ui-icon-seek-prev"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-seek-end"><span class="ui-icon ui-icon-seek-end"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-seek-first"><span class="ui-icon ui-icon-seek-first"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-stop"><span class="ui-icon ui-icon-stop"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-eject"><span class="ui-icon ui-icon-eject"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-volume-off"><span class="ui-icon ui-icon-volume-off"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-volume-on"><span class="ui-icon ui-icon-volume-on"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-power"><span class="ui-icon ui-icon-power"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-signal-diag"><span class="ui-icon ui-icon-signal-diag"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-signal"><span class="ui-icon ui-icon-signal"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-battery-0"><span class="ui-icon ui-icon-battery-0"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-battery-1"><span class="ui-icon ui-icon-battery-1"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-battery-2"><span class="ui-icon ui-icon-battery-2"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-battery-3"><span class="ui-icon ui-icon-battery-3"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-plus"><span class="ui-icon ui-icon-circle-plus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-minus"><span class="ui-icon ui-icon-circle-minus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-close"><span class="ui-icon ui-icon-circle-close"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-triangle-e"><span class="ui-icon ui-icon-circle-triangle-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-triangle-s"><span class="ui-icon ui-icon-circle-triangle-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-triangle-w"><span class="ui-icon ui-icon-circle-triangle-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-triangle-n"><span class="ui-icon ui-icon-circle-triangle-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-arrow-e"><span class="ui-icon ui-icon-circle-arrow-e"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-arrow-s"><span class="ui-icon ui-icon-circle-arrow-s"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-arrow-w"><span class="ui-icon ui-icon-circle-arrow-w"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-arrow-n"><span class="ui-icon ui-icon-circle-arrow-n"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-zoomin"><span class="ui-icon ui-icon-circle-zoomin"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-zoomout"><span class="ui-icon ui-icon-circle-zoomout"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circle-check"><span class="ui-icon ui-icon-circle-check"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circlesmall-plus"><span class="ui-icon ui-icon-circlesmall-plus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circlesmall-minus"><span class="ui-icon ui-icon-circlesmall-minus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-circlesmall-close"><span class="ui-icon ui-icon-circlesmall-close"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-squaresmall-plus"><span class="ui-icon ui-icon-squaresmall-plus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-squaresmall-minus"><span class="ui-icon ui-icon-squaresmall-minus"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-squaresmall-close"><span class="ui-icon ui-icon-squaresmall-close"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-grip-dotted-vertical"><span class="ui-icon ui-icon-grip-dotted-vertical"></span></li>

                    <li class="ui-state-default ui-corner-all" title=".ui-icon-grip-dotted-horizontal"><span class="ui-icon ui-icon-grip-dotted-horizontal"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-grip-solid-vertical"><span class="ui-icon ui-icon-grip-solid-vertical"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-grip-solid-horizontal"><span class="ui-icon ui-icon-grip-solid-horizontal"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-gripsmall-diagonal-se"><span class="ui-icon ui-icon-gripsmall-diagonal-se"></span></li>
                    <li class="ui-state-default ui-corner-all" title=".ui-icon-grip-diagonal-se"><span class="ui-icon ui-icon-grip-diagonal-se"></span></li>
                </ul>
            </div>

            <!--Tooltip-->
            <div class="widget tooltip-wrapper">
                <h4 class="page-header">Tooltip</h4>
                <img src="http://placehold.it/300x120" alt="Image 2" class="tooltip-1" title="Oh look, this is awesome!" />
                <img src="http://placehold.it/300x120" alt="Image 1" class="tooltip-2" title="Hey, give me attention!" />
            </div>
        </div>

        <div class="span4">
            <!--Button-->
            <div class="widget">
                <h4 class="page-header">Button</h4>
                <button type="button" id="button">Button element</button>
                <button type="button" id="button2" class="ui-priority-primary">Button element</button>
            </div>

            <!--Autocomplete-->
            <div class="widget">
                <h4 class="page-header">
                    <span class="ui-icon ui-icon-lightbulb ui-icon-inline" title="Try typing an programming language name!"></span>
                    Autocomplete
                </h4>
                <input type="text" id="autocomplete" class="span4" />
            </div>

            <!--Spinner-->
            <div class="widget">
                <h4 class="page-header">Spinner</h4>
                <input type="text" id="spinner" value="0" class="span4" />
            </div>

            <!--Slider-->
            <div class="widget">
                <h4 class="page-header">Slider</h4>
                <div id="slider"></div>
            </div>

            <!--Datepicker-->
            <div class="widget">
                <h4 class="page-header">Datepicker</h4>
                <div id="datepicker"></div>
            </div>

            <!--Menu-->
            <div class="widget">
                <h4 class="page-header">Menu</h4>
                <ul id="menu">
                    <li><a href="#">Item 1</a></li>
                    <li><a href="#">Item 2</a></li>
                    <li>
                        <a href="#">Item 3</a>
                        <ul>
                            <li><a href="#">Item 3.1</a></li>
                            <li><a href="#">Item 3.2</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Item 4</a></li>
                </ul>
            </div>

            <!--Progressbar-->
            <div class="widget">
                <h4 class="page-header">
                    <span class="ui-icon ui-icon-lightbulb ui-icon-inline" title="Add 'ui-progressbar-striped' and 'ui-progressbar-animated' classes to achieve the animated progressbar!"></span>
                    Progressbar
                </h4>
                <div id="progressbar"></div>
                <div id="progressbar2" class="ui-progressbar-striped" title=".ui-progressbar-striped"></div>
                <div id="progressbar3" class="ui-progressbar-striped ui-progressbar-animated" title=".ui-progressbar-striped.ui-progressbar-animated"></div>
            </div>

            <!--State classes-->
            <div class="widget">
                <h4 class="page-header">Highlight/error</h4>

                <div class="ui-widget state">
                    <div class="ui-corner-all ui-state-highlight" style="padding:7px">
                        <span class="ui-icon ui-icon-check" style="float:left"></span>
                        <strong>Look!</strong> This has been highlighted!
                    </div>
                </div>

                <div class="ui-widget state">
                    <div class="ui-corner-all ui-state-error" style="padding:7px">
                        <span class="ui-icon ui-icon-alert" style="float:left"></span>
                        <strong>Error!</strong> Damn, run to the hills!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="navbar navbar-inverse navbar-fixed-bottom" style="margin: 50px 0 0">
    <div class="navbar-inner">
        <div class="container">
            <div class="navbar-text pull-left">
                Created by <a href="http://github.com/gustavohenke" class="navbar-link">@gustavohenke</a>
            </div>
            <div class="navbar-text pull-right">
                Version 0.1.0
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="support/scripts/jquery.js"></script>
<script type="text/javascript" src="support/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="support/scripts/demo.js"></script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-38298327-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
</body>
</html>
