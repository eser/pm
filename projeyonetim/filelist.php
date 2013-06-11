<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!-- Always force latest IE rendering engine or request Chrome Frame -->
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<title>Plastique Theme</title>
<link href="stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
<style>	
	label.note {
		margin-bottom:-10px;
	}
</style>

<!--[if lt IE 9]>
<script src="javascripts/html5shiv.js" type="text/javascript"></script><script src="javascripts/excanvas.js" type="text/javascript"></script><script src="javascripts/iefix.js" type="text/javascript"></script><link href="stylesheets/iefix.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->

<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
</head>
<body>
<div id="modal" class="black-box modal hide fade">
  <div class="modal-header tab-header" >
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <span>Add Note</span> </div>
  <div class="modal-body separator" style="height:250px; color:#000">
    
				<div class="input">
                    <label for="User" class="caption">User</label>
                  <select name="User" id="User" placeholder="User" class="fill-up chzn-select">
                    <option>[ANY]</option>
                  </select>
                </div>
                <div class="input">
                    <label for="Role" class="caption">Role</label>
                  <select name="Role" id="Role" placeholder="Role" class="fill-up chzn-select">
                    <option>[ANY]</option>
                  </select>
                </div>

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
    <li class=""> <a href=""> <i class="icon-share"></i>Project Name </a> </li>
    <li class=""> <a href="overview.html"> <i class="icon-th"></i> Overview </a> </li>
    <li class=""> <a href="activity.html"> <i class="icon-thumbs-up"></i> Activity </a> </li>
    <li class=""> <a href="issues.html"> <i class="icon-share-alt"></i> Issues </a> </li>
    <li class=""> <a href="newissues.html"> <i class="icon-flag"></i> New Issues </a> </li>
    <li class=""> <a href="news.html"> <i class="icon-table"></i> News </a> </li>
    <li class=""> <a href="pages.html"> <i class="icon-table"></i> Pages </a> </li>
    <li class=""> <a href="files.html"> <i class="icon-table"></i> Files </a> </li>
    <li class=""> <a href="milesotones.html"> <i class="icon-table"></i> Milestones </a> </li>
    <li class=""> <a href="sections.html"> <i class="icon-table"></i> Sections </a> </li>
    <li class=""> <a href="users.html"> <i class="icon-table"></i> Users </a> </li>
    <li class=""> <a href="settings.html"> <i class="icon-table"></i> Settings </a> </li>
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
      <div class="span12">
        <div class="box " style="position:relative;">
          <div class="tab-header" > Member List
          </div>
          <div class="tab-pane padded">
            <div class="span4" style="text-align:center; padding:-10px;">
              <label for="Section">&nbsp;</label>
              
            <div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi"> <a tabindex="0" class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_first">First</a><a tabindex="0" class="previous fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_previous">&laquo;</a><span><a tabindex="0" class="fg-button ui-button ui-state-default ui-state-disabled">1</a></span><a tabindex="0" class="next fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_next">Next</a><a tabindex="0" class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default ui-state-disabled" id="DataTables_Table_0_last">Last</a></div>
          </div>
          <div class="pull-right">
                <button type="submit" class="button blue">New Upload</button>
              </div>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Type</th>
                <th>File Name</th>
                <th>Version</th>
                <th>Issue</th>
                <th>Milestone</th>
                <th>Description</th>
                
              </tr>
            </thead>
            <tbody>
              <tr class="gradeX">
                <td>1</td>
                <td>Internet Explorer 4.0</td>
                <td>Internet Explorer 4.0</td>
                <td>Internet Explorer 4.0</td>
                <td>Internet Explorer 4.0</td>
                <td>Internet Explorer 4.0</td>
               
              </tr>
            </tbody>
          </table>
          <div class="form-actions"> </div>
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
