<!DOCTYPE html>
<?php include('veritabani.php'); ?>
<html>
<head>
  <meta charset="utf-8">
  <!-- Always force latest IE rendering engine or request Chrome Frame -->
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <title>Plastique Theme</title>

  <link href="../../stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />

  <!--[if lt IE 9]>
<script src="../../javascripts/html5shiv.js" type="text/javascript"></script><script src="../../javascripts/excanvas.js" type="text/javascript"></script><script src="../../javascripts/iefix.js" type="text/javascript"></script><link href="../../stylesheets/iefix.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->

  <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
</head>
<body>
<!-- div 1 -->
<div id="modal" class="black-box modal hide fade">
  <div class="modal-header tab-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <span>Yeni kayıt</span>
  </div>
  <div class="modal-body separator">
    <form class="fill-up">
    <div class="container-fluid">
    <div class="row-fluid">
  <div class="span12">
 
  
   <div class="padded">
   <!-- Kayıt Ekleme -->
  <div class="note">Name</div>
  <div class="input"><input type="text" placeholder="Name"/></div>
  <div class="note">Surname</div>
  <div class="input"><input type="text" placeholder="Surname"/></div>
  <div class="note">School Number</div>
  <div class="input"><input type="text" placeholder="School Number"/></div>
  <div class="note">Not</div>
  <div class="input"><input type="text" placeholder="Not"/></div>
  </div></div></div>
  </div></form>
  </div>
  <div class="modal-footer">
    <div class="inner-well">
      <a class="button mini rounded light-gray" data-dismiss="modal">Close</a>
      <a class="button mini rounded blue">Add</a>
    </div>
  </div>
</div>

<div id="modal-gallery" class="black-box modal modal-gallery hide fade">
  <div class="modal-header tab-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <span class="modal-title"></span>
  </div>
  <div class="modal-body"><div class="modal-image"></div></div>
  <div class="modal-footer">
    <div class="pull-left">
      You can also change the images<br/> by scrolling the mouse wheel!
    </div>
    <div class="pull-right">
      <a class="button blue modal-next">Next <i class="icon-arrow-right icon-white"></i></a>
      <a class="button gray modal-prev"><i class="icon-arrow-left icon-white"></i> Previous</a>
      <a class="button green modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play icon-white"></i> Slideshow</a>
      <a class="button black" target="_blank"><i class="icon-download"></i> Download</a>
    </div>
  </div>
</div>
<nav id="primary" class="main-nav">
  <ul>

    <li class="">
      <a href="../dashboard/stats.html">
        <i class="icon-dashboard"></i> Dashboard
      </a>
    </li>

    <li class="">
      <a href="../form_elements/standard.html">
        <i class="icon-list-alt"></i> Forms
      </a>
    </li>

    <li class="active">
      <a href="buttons_dropdowns.html">
          <i class="icon-beaker"></i> UI Lab
      </a>
    </li>

    <li class="">
      <a href="../widgets/widgets.html">
          <i class="icon-plus-sign"></i> Widgets
      </a>
    </li>

    <li class="">
      <a href="../charts/charts.html">
          <i class="icon-bar-chart"></i> Charts
      </a>
    </li>





    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-share-alt"></i>More <span class="caret"></span></a>

      <ul class="dropdown-menu">
        <li>
          <a href="../error_404.html">
              <i class="icon-warning-sign"></i> Error 404
          </a>
        </li>

        

        <li>
          <a href="../docs/docs.html">
              <i class="icon-book"></i> Documentation
          </a>
        </li>

        
        <li class="divider"></li>
        <li>
          <a href="../login/login.html">
              <i class="icon-off"></i> Log out (login page)
          </a>
        </li>
      </ul>
    </li>

  </ul>
</nav><nav id="secondary" class="main-nav">

  <div class="profile-menu">

    <div class="pull-left">
      <div class="avatar">
        <img src="../../images/avatar.png" />
      </div>
    </div>

    <div class="pull-left">
      <div class="title">
        Plastique
      </div>
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
    <li class="">
  <a href="buttons_dropdowns.html">
      <i class="icon-share"></i> Buttons & dropdowns
  </a>
</li>

<li class="">
  <a href="grid.html">
      <i class="icon-th"></i> Grid
  </a>
</li>

<li class="">
  <a href="icons.html">
      <i class="icon-thumbs-up"></i> Icons
  </a>
</li>

<li class="">
  <a href="modals.html">
      <i class="icon-share-alt"></i> Modals
  </a>
</li>

<li class="">
  <a href="notifications.html">
      <i class="icon-flag"></i> Notifications
  </a>
</li>

<li class="active">
  <a href="tables.html">
      <i class="icon-table"></i> Tables
  </a>
</li>
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
          <li class="active"><a href="#">Here</a></li>
        </ul>
        <a class="search-button-trigger" href="#"><i class="icon-search"></i></a>
      </div>
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
  
  <table class="table table-striped table-bordered box">
  <thead>
  <tr>
    <th colspan="4">Sınıf Listesi</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><strong>Name</strong></td>
    <td><strong>Surname</strong></td>
    <td><strong>School Number</strong></td>
    <td><strong>Not</strong></td>
  </tr>
  <?php 
	
	$query=mysql_query("SELECT id,ad,soyad,okulno,notlar FROM listem ");
  	while($oku=mysql_fetch_array($query)){ 
	?>
 <tr>
 <td><?php echo $oku['ad']; ?></td>
 <td><?php echo $oku['soyad']; ?></td>
 <td><?php echo $oku['okulno']; ?></td>
 <td><?php echo $oku['notlar']; ?></td>
 </tr>
 <?php } ?>
  </tbody>
  <tfoot>
  <tr>
    <td colspan="4">
      <div class="clearfix" style="padding: 0 5px;">
        <div class="pull-left"><a href="#" class="button blue" id="modal-link">Add</a></div>
      </div>
    </td>
  </tr>
  </tfoot>
</table>

  </div>

  <div class="span6"></div>
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
<script src="../../javascripts/application.js" type="text/javascript"></script><script src="../../javascripts/docs.js" type="text/javascript"></script><script src="../../javascripts/docs_charts.js" type="text/javascript"></script><script src="../../javascripts/documentation.js" type="text/javascript"></script><script src="../../javascripts/prettify.js" type="text/javascript"></script><link href="../../stylesheets/prettify.css" media="screen" rel="stylesheet" type="text/css" />
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
