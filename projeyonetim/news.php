<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!-- Always force latest IE rendering engine or request Chrome Frame -->
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<title>Plastique Theme</title>
<link href="stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 9]>
<script src="javascripts/html5shiv.js" type="text/javascript"></script><script src="javascripts/excanvas.js" type="text/javascript"></script><script src="javascripts/iefix.js" type="text/javascript"></script><link href="stylesheets/iefix.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->

<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
</head>
<body>
<div id="modal" class="black-box modal hide fade">
  <div class="modal-header tab-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <span>Some modal title</span> </div>
  <div class="modal-body separator">
    <h4>Text in a modal</h4>
    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>
  </div>
  <div class="modal-footer">
    <div class="inner-well"> <a class="button mini rounded light-gray" data-dismiss="modal">Close</a> <a class="button mini rounded blue">Save changes</a> </div>
  </div>
</div>
<div id="modal-gallery" class="black-box modal modal-gallery hide fade">
  <div class="modal-header tab-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <span class="modal-title"></span> </div>
  <div class="modal-body">
    <div class="modal-image"></div>
  </div>
  <div class="modal-footer">
    <div class="pull-left"> You can also change the images<br/>
      by scrolling the mouse wheel! </div>
    <div class="pull-right"> <a class="button blue modal-next">Next <i class="icon-arrow-right icon-white"></i></a> <a class="button gray modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a> <a class="button green modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Slideshow</a> <a class="button black" target="_blank"><i class="icon-download"></i> Download</a> </div>
  </div>
</div>
<nav id="primary" class="main-nav">
  <ul>
    <li class=""> <a href="index.html"> <i class="icon-dashboard"></i> Home </a> </li>
    <li class=""> <a href="mypage.html"> <i class="icon-plus-sign"></i> Mypage </a> </li>
    <li class=""> <a href="projects.html"> <i class="icon-bar-chart"></i> Projects </a> </li>
    <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-share-alt"></i>More <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li> <a href="../error_404.html"> <i class="icon-warning-sign"></i> Error 404 </a> </li>
        <li> <a href="../docs/docs.html"> <i class="icon-book"></i> Documentation </a> </li>
        <li class="divider"></li>
        <li> <a href="../login/login.html"> <i class="icon-off"></i> Log out (login page) </a> </li>
      </ul>
    </li>
  </ul>
</nav>
<nav id="secondary" class="main-nav">
  <div class="profile-menu">
    <div class="pull-left">
      <div class="avatar"> <img src="images/avatar.png" /> </div>
    </div>
    <div class="pull-left">
      <div class="title"> Plastique </div>
      <div class="btn-group">
        <button class="button mini inset black"><i class="icon-search"></i></button>
        <button class="button mini inset black">Projects</button>
        <button class="button mini inset black dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i></button>
        <ul class="dropdown-menu black-box-dropdown">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li><a href="#">Separated link</a></li>
        </ul>
      </div>
    </div>
    <div class="pull-right profile-menu-nav-collapse">
      <button class="button black"><i class="icon-reorder"></i></button>
    </div>
  </div>
  <ul class="secondary-nav-menu">
    <li class=""> <a href=""> <i class="icon-share"></i> New Project </a> </li>
    <li class=""> <a href=""> <i class="icon-th"></i> Project List </a> </li>
    <li class=""> <a href=""> <i class="icon-thumbs-up"></i> ----- </a> </li>
    <li class=""> <a href=""> <i class="icon-share-alt"></i> ----- </a> </li>
    <li class=""> <a href=""> <i class="icon-flag"></i> ----- </a> </li>
    <li class=""> <a href=""> <i class="icon-table"></i> ----- </a> </li>
  </ul>
</nav>
<section id="main">
  <div class="top-nav">
    <div class="container-fluid">
      <div class="row-fluid search-button-bar-container">
        <div class="span12">
          <ul class="breadcrumb">
            <li><a href="#"><i class="icon-home"></i> Some</a></li>
            <li><a href="#">Nice</a></li>
            <li><a href="#">Breadcrumbs</a></li>
            <li class=""><a href="#">Here</a></li>
          </ul>
          <a class="search-button-trigger" href="#"><i class="icon-search"></i></a> </div>
      </div>
      <div class="row-fluid search-bar-nav">
        <div class="span12">
          <form>
            <input type="text" class="search" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span6">
        <div class="box">
          <div class="tab-header"> Forms <span class="pull-right"> <span class="options"> <a href="#"><i class="icon-cog"></i></a> </span> </span> </div>
          <form class="fill-up">
            <div class="row-fluid">
              <div class="span12">
                <div class="padded">
                  <div class="input">
                    <label for="Name" class="caption">Title</label>
                      <input type="text" placeholder="Name" name="Name"/>
                    
                  </div>
                  <div class="input">
                     <label for="Category" class="caption">Category</label>
                      <select name="Category" id="Category" placeholder="Category" class="fill-up chzn-select">
                        <option>None</option>
                      </select>
                    
                  </div>
                  <div class="input">
                    <label for="Name" class="caption">Description</label>
                      <textarea placeholder="This is a textarea" rows="6"></textarea>
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <div class="pull-right">
                <button type="submit" class="button blue">Create</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="footer">
          <div>2012 &copy; Plastique Admin Theme</div>
          <div>Carefully crafted by <a href="https://wrapbootstrap.com/user/andrei4002">andrei4002</a></div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/html" id="template-notification">
  <div class="notification animated fadeInLeftMiddle fast{{ item.itemClass }}">
    <div class="left">
      <div style="background-image: url({{ item.imagePath }})" class="{{ item.imageClass }}"></div>
    </div>
    <div class="right">
      <div class="inner">{{ item.text }}</div>
      <div class="time">{{ item.time }}</div>
    </div>

    <i class="icon-remove-sign hide"></i>
  </div>
</script> 
<script type="text/html" id="template-notifications">
  <div class="container">
    <div class="row" id="notifications-wrapper">
      <div id="notifications" class="{{ bootstrapPositionClass }} notifications animated">
        <div id="dismiss-all" class="dismiss-all button blue">Dismiss all</div>
        <div id="content">
          <div id="notes"></div>
        </div>
      </div>
    </div>
  </div>
</script> 
<script src="javascripts/application.js" type="text/javascript"></script><script src="javascripts/docs.js" type="text/javascript"></script><script src="javascripts/docs_charts.js" type="text/javascript"></script><script src="javascripts/documentation.js" type="text/javascript"></script><script src="javascripts/prettify.js" type="text/javascript"></script>
<link href="stylesheets/prettify.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    prettyPrint()
</script> 
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-35778683-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
</body>
</html>
