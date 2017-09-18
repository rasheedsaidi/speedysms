<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\HomeAsset;

HomeAsset::register($this);
$home_url = urldecode(Url::toRoute(['/site/index']));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html><!-- #0B670B #054705 -->
<html><head>
	<title>SpeedySMS - Simple and Fast SMS Messaging</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/favicon-16x16.png">
    <link rel="manifest" href="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo Yii::$app->request->baseUrl; ?>/web/images/fav/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
	<meta name="description" content="Send bulk SMS quickly and reliably.">

	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43064934-1', 'auto');
  ga('send', 'pageview');

</script>      

<link rel='dns-prefetch' href='http://fonts.googleapis.com/'/>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

 
</head>
<body class="home page-template-default page page-id-7  color-custom layout-full-width header-white header-bg">
<?php $this->beginBody() ?>
<?= $content ?>
 
<div id="Wrapper">
 
 
<header id="Header">
 
<div class="header_placeholder"></div>
<div id="Top_bar">
<div class="container">
<div class="column one">
 
<div class="logo">
<h1><a id="logo" href="index.html" title="tawk.to"><img class="scale-with-grid" src="<?php echo Yii::$app->request->baseUrl; ?>/web/images/logo.jpg" alt="speedysms logo"/></a></h1> </div>
 
<div class="menu_wrapper">
 
<a id="header_action_button" href="index.html">Sign Up</a>
 
 
<!--form method="get" id="searchform" action="https://www.tawk.to/">
<a class="icon_search icon" href="#"><i class="icon-search-line"></i></a>
<a class="icon_close icon" href="#"><i class="icon-cancel"></i></a>
<input type="text" class="field" name="s" id="s" placeholder="Enter your search"/>
<input type="submit" class="submit" value="" style="display:none;"/>
</form-->
 
<nav id="menu" class="menu-main-menu-container"><ul id="menu-main-menu" class="menu"><li id="menu-item-1647" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="features/index.html"><span>Why SpeedySMS</span></a>
<ul class="sub-menu ">
<li id="menu-item-844" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="tawk-to-for-windows/index.html"><span>Advantages</span></a></li>
<li id="menu-item-752" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="download-the-tawk-to-mac-osx/index.html"><span>Mission</span></a></li>
<li id="menu-item-266" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="features/android-app/index.html"><span>Vision</span></a></li>
</ul>
</li>
<li id="menu-item-652" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="knowledgebase/index.html"><span>Pricing</span></a></li>
<li id="menu-item-1648" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#"><span>API</span></a>
</li>
<li id="menu-item-192" class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://dashboard.tawk.to/"><span>Login</span></a></li>
</ul></nav> <a class="responsive-menu-toggle" href="#"><i class='icon-menu'></i></a>
</div>
</div>
</div>
</div>
</header>
 
<div id="Content">
<div class="content_wrapper clearfix">
 
<div class="sections_group">
<div class="section   " style="padding-top:20px; padding-bottom:20px; background-color:#ffffff"><div class="section_wrapper clearfix"><div class="items_group clearfix"><div class="column one column_column"><center><h2>Simple and Fast SMS Messaging</h2></center><center>
<br><h5>The <b> bulk sms messaging</b> platform that lets you <b>send bulk sms </b> at <b>99.9% delivery rate</b> <br>
at <b>relatively high speed</b> with a simple, sleek, and <b>friendly</b> user interface</h5></center></div><div class="column one-second column_column"><img width="560" height="315" src="<?php echo Yii::$app->request->baseUrl; ?>/web/images/dash1.png" ></div><div class="column one-second column_column"> <div id="twk-signup-form-container">
<form name="twk-signup-form" method="post" id="twk-signup-form">
<h6 id="twk-signup-form-header">To <b><span class="hlight">request a quote</span></b> is really simple.</h6>
<div class="twk-input-container clearfix">
<input type="text" name="twk-name" maxlength="101" id="twk-name" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="Your name">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label for="twk-name" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
</div>
<div class="twk-input-container clearfix">
<input type="email" name="twk-email" id="twk-email" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="Your email">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label id="twk-email-label" for="twk-email" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
<div id="twk-email-loader" class="twk-loader"></div>
</div>
<div class="twk-input-container clearfix">
<input type="text" name="twk-name" maxlength="101" id="twk-name" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="Your phone number">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label for="twk-name" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
</div>
<div class="twk-input-container clearfix">
<textarea type="password" name="twk-password" id="twk-password" class="twk-text" aria-required="true" aria-invalid="false" placeholder="Type your message here."></textarea>
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label for="twk-password" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
<div class="twk-password-meter">
<div class="twk-password-meter-bg">
<div class="twk-password-meter-bar"></div>
</div>
</div>
<div class="twk-password-meter-message"></div>
</div>
<div class="twk-button-container">
<input type="submit" id="twk-sumbit-btn" value="Request quote" class="wpcf7-form-control wpcf7-submit button button_filled button_large">
<div id="twk-submit-loader" class="twk-loader"></div>
</div>
</form>
<p id="twk-submit-message" class="twk-error"></p>
</div>
</div></div></div></div>

<div class="section" style="padding-top:0px; padding-bottom:0px; background-color:#d1f0f3"><div class="section_wrapper clearfix"><div class="items_group clearfix"><div class="column one column_column"><br/>
<br/>
<center><h3>How much does it cost?</h3></center>

</div><div class="column one-second column_icon_box"><div class="icon_box icon_position_top"><div class="desc_wrapper"><h4 class="title">Enter no of messages</h4>
<div class="twk-input-container clearfix">
<input type="number" name="no_of_messages" id="no_of_messages" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="# of messages to send">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label id="twk-email-label" for="twk-email" class="error twk-error" generated="true"></label>
<div class="clear"></div></div>
</div>
</div></div></div><div class="column one-second column_icon_box"><div class="icon_box icon_position_top"><div class="desc_wrapper"><h4 class="title">Enter Bulk SMS Budget</h4><div class="twk-input-container clearfix">
<input type="number" name="no_of_messages" id="no_of_messages" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="# of messages to send">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label id="twk-email-label" for="twk-email" class="error twk-error" generated="true"></label>
<div class="clear"></div></div></div></div></div></div></div></div></div>

<div class="section" style="padding-top:0px; padding-bottom:0px; background-color:#f5f5f5"><div class="section_wrapper clearfix"><div class="items_group clearfix"><div class="column one column_column"><br/>
<br/>
<center><h3>Follow these steps to get started</h3></center></div><div class="column one-third column_icon_box"><div class="icon_box icon_position_top"><div class="icon_wrapper"><i class="icon-user"></i></div><div class="desc_wrapper"><h4 class="title">Sigup and login</h4><hr/><div class="desc">Follow the signup or login link in the menu above to setup your account.</div></div></div></div><div class="column one-third column_icon_box"><div class="icon_box icon_position_top"><div class="icon_wrapper"><i class="icon-tape"></i></div><div class="desc_wrapper"><h4 class="title">Buy SMS plan</h4><hr/><div class="desc">Visit the pricing page to buy online. Select from the price list and associated features.</div></div></div></div><div class="column one-third column_icon_box"><div class="icon_box icon_position_top"><div class="icon_wrapper"><i class="icon-chart-line"></i></div><div class="desc_wrapper"><h4 class="title">Send and track progress</h4><hr/><div class="desc">Send SMS and Monitor how your messages are delivered. Check and review message statuses from your dashborad.</div></div></div></div></div></div></div>

<div class="section" style="padding-top:60px; padding-bottom:20px; background-color:#fff"><div class="section_wrapper clearfix"><div class="items_group clearfix"><div class="column one column_column"><center><h3>All the features and benefits you would expect from bulk sms.</h3>
<h5>SpeedySMS is the right choice to send <b>bulksms</b>.<br/> It's feature-rich, always putting you first</h5></center></div><!--div class="column one-second column_faq"><div class="faq"><h4 class="title">Have some questions?</h4><div class="mfn-acc faq_wrapper "><div class="question"><h5><span class="icon">?</span>How can you offer this for free?</h5><div class="answer">Currently we generate revenue by providing live answering services for a select group of customers - though to use the software yourself is completely free, with no limits at all on the number of Agents, Chat Volumes or sites that you can add widgets to. It's truly 100% free.</div></div>
<div class="question"><h5><span class="icon">?</span>How many Agents can we add?</h5><div class="answer">As many as you like! There are no limits to the number of agents that you can share a site with. tawk.to is an Agent Centric chat application, which means every agent has their own account and you can share 'sites'.</div></div>
<div class="question"><h5><span class="icon">?</span>Do you limit the number of Concurrent chats?</h5><div class="answer">No. You can answer as many concurrent chats as you wish. There are no limits.</div></div>
<div class="question"><h5><span class="icon">?</span>Is our data safe?</h5><div class="answer">We take your privacy, and data security very seriously. All communication between you and your visitors is over 128bit Secure Socket Layer, and all data is housed on encrypted servers.</div></div>
<div class="question"><h5><span class="icon">?</span>Will I ever be charged to use the software?</h5><div class="answer">No! The Desktop and Mobile apps are all 100% free. We have no intention to charge you to use the software, in fact - it completely goes against our business model.</div></div>
<div class="question"><h5><span class="icon">?</span>Are there any Ads?</h5><div class="answer">No! We do not have any annoying Ads within tawk.to! </div></div>
</div></div>
</div--><!--div class="column one-second column_column"><h4>What you can do with tawk.to </h4>
<h6><i class="icon-eye"></i>   <a href='#'>Monitor website visitors in real time</a></h6>
<h6><i class="icon-mobile"></i>   <a href='features/android-app/index.html'>Answer chats from your Mobile Device</a></h6>
<h6><i class="icon-flash"></i>   <a href='knowledgebase/advanced-features/creating-and-managing-triggers/index.html'>Proactively engage visitors with Triggers</a></h6>
<h6><i class="icon-brush"></i>   <a href='knowledgebase/chat-widget/customize-the-chat-widget/index.html'>Customize your Visitor Widget to suit your site</a></h6>
<h6><i class="icon-globe"></i>   <a href='knowledgebase/chat-widget/modify-the-greetings-for-the-widget/index.html'>Localize greetings and messages in your Language</a></h6>
<h6><i class="icon-tape"></i>   <a href='knowledgebase/using-the-dashboard/creating-and-managing-shortcuts/index.html'>Respond quickly with Predefined Shortcuts</a></h6>
<h6><i class="icon-tools"></i>   <a href='knowledgebase/integrations/index.html'>Integrate with Wordpress, Joomla, Magento, etc..</a></h6>
<h6><i class="icon-cog"></i>     <a href='features/index.html'>...and much much more.</a></h6></div--></div></div></div>

<div class="section" style="padding-top:60px; padding-bottom:20px; background-color:#FFFFFF"><div class="section_wrapper clearfix"><div class="items_group clearfix"><div class="column one column_column"><center><h1>You are in <span class="hlight">great</span> company</h2></center></div><!--div class="column one column_clients"><div class="clients"><ul><li class="" style="width:20%"><div class="client_wrapper"><img width="369" height="93" src="wp-content/uploads/2014/05/client_3.png" class="scale-with-grid wp-post-image" alt="" srcset="https://www.tawk.to/wp-content/uploads/2014/05/client_3.png 369w, https://www.tawk.to/wp-content/uploads/2014/05/client_3-300x75.png 300w, https://www.tawk.to/wp-content/uploads/2014/05/client_3-260x65.png 260w, https://www.tawk.to/wp-content/uploads/2014/05/client_3-50x12.png 50w, https://www.tawk.to/wp-content/uploads/2014/05/client_3-366x93.png 366w" sizes="(max-width: 369px) 100vw, 369px"/></div></li><li class="" style="width:20%"><div class="client_wrapper"><img width="201" height="56" src="wp-content/uploads/2014/05/client_6.png" class="scale-with-grid wp-post-image" alt="" srcset="https://www.tawk.to/wp-content/uploads/2014/05/client_6.png 201w, https://www.tawk.to/wp-content/uploads/2014/05/client_6-50x13.png 50w" sizes="(max-width: 201px) 100vw, 201px"/></div></li><li class="" style="width:20%"><div class="client_wrapper"><img width="201" height="56" src="wp-content/uploads/2016/06/hyundai-logo.png" class="scale-with-grid wp-post-image" alt=""/></div></li><li class="" style="width:20%"><div class="client_wrapper"><img width="201" height="56" src="wp-content/uploads/2016/06/racv-logo.png" class="scale-with-grid wp-post-image" alt=""/></div></li><li class="last_in_row" style="width:20%"><div class="client_wrapper"><img width="201" height="56" src="wp-content/uploads/2016/06/pizzahut-logo.png" class="scale-with-grid wp-post-image" alt=""/></div></li><li class=" last_row" style="width:20%"><div class="client_wrapper"><img width="201" height="56" src="wp-content/uploads/2016/06/europcarlogo.png" class="scale-with-grid wp-post-image" alt=""/></div></li><li class=" last_row" style="width:20%"><div class="client_wrapper"><img width="369" height="93" src="wp-content/uploads/2014/05/benz.png" class="scale-with-grid wp-post-image" alt="" srcset="https://www.tawk.to/wp-content/uploads/2014/05/benz.png 369w, https://www.tawk.to/wp-content/uploads/2014/05/benz-300x75.png 300w, https://www.tawk.to/wp-content/uploads/2014/05/benz-260x65.png 260w, https://www.tawk.to/wp-content/uploads/2014/05/benz-50x12.png 50w, https://www.tawk.to/wp-content/uploads/2014/05/benz-366x93.png 366w" sizes="(max-width: 369px) 100vw, 369px"/></div></li><li class=" last_row" style="width:20%"><div class="client_wrapper"><img width="369" height="93" src="wp-content/uploads/2014/05/client_11.png" class="scale-with-grid wp-post-image" alt="" srcset="https://www.tawk.to/wp-content/uploads/2014/05/client_11.png 369w, https://www.tawk.to/wp-content/uploads/2014/05/client_11-300x75.png 300w, https://www.tawk.to/wp-content/uploads/2014/05/client_11-260x65.png 260w, https://www.tawk.to/wp-content/uploads/2014/05/client_11-50x12.png 50w, https://www.tawk.to/wp-content/uploads/2014/05/client_11-366x93.png 366w" sizes="(max-width: 369px) 100vw, 369px"/></div></li><li class=" last_row last_row_mobile" style="width:20%"><div class="client_wrapper"><img width="220" height="60" src="wp-content/uploads/2014/05/client_5.png" class="scale-with-grid wp-post-image" alt="" srcset="https://www.tawk.to/wp-content/uploads/2014/05/client_5.png 220w, https://www.tawk.to/wp-content/uploads/2014/05/client_5-50x13.png 50w" sizes="(max-width: 220px) 100vw, 220px"/></div></li><li class="last_in_row last_row last_row_mobile" style="width:20%"><div class="client_wrapper"><img width="369" height="93" src="wp-content/uploads/2014/05/client_4.png" class="scale-with-grid wp-post-image" alt="" srcset="https://www.tawk.to/wp-content/uploads/2014/05/client_4.png 369w, https://www.tawk.to/wp-content/uploads/2014/05/client_4-300x75.png 300w, https://www.tawk.to/wp-content/uploads/2014/05/client_4-260x65.png 260w, https://www.tawk.to/wp-content/uploads/2014/05/client_4-50x12.png 50w, https://www.tawk.to/wp-content/uploads/2014/05/client_4-366x93.png 366w" sizes="(max-width: 369px) 100vw, 369px"/></div></li></ul>
</div>
</div--></div></div></div><div class="section   " style="padding-top:0px; padding-bottom:0px; background-color:#f5f5f5"><div class="section_wrapper clearfix"><div class="items_group clearfix"><div class="column one column_divider"><hr style="margin: 0 auto 60px; border:none; width:0; height:0;"/>
</div><div class="column one-second column_column"><h2>People <span class="hlight">read</span> Text Messages</h2>
<br/><h5>Your customers have spoken loud and clear, text messaging is their communications channel of choice - and you need to be where your customers are.</h5>
Easy signup • Relatively cheap • Simply fast</div><div class="column one-second column_column"> <div id="twk-signup-form-container">
<form name="twk-signup-form" method="post" id="twk-signup-form">
<h6 id="twk-signup-form-header">To <b><span class="hlight">request a quote</span></b> is really simple.</h6>
<div class="twk-input-container clearfix">
<input type="text" name="twk-name" maxlength="101" id="twk-name" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="Your name">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label for="twk-name" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
</div>
<div class="twk-input-container clearfix">
<input type="email" name="twk-email" id="twk-email" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="Your email">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label id="twk-email-label" for="twk-email" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
<div id="twk-email-loader" class="twk-loader"></div>
</div>
<div class="twk-input-container clearfix">
<input type="text" name="twk-name" maxlength="101" id="twk-name" class="twk-text required" aria-required="true" aria-invalid="false" placeholder="Your phone number">
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label for="twk-name" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
</div>
<div class="twk-input-container clearfix">
<textarea type="password" name="twk-password" id="twk-password" class="twk-text" aria-required="true" aria-invalid="false" placeholder="Type your message here."></textarea>
<div class="twk-error-container">
<span class="twk-error-alert"></span>
<label for="twk-password" class="error twk-error" generated="true"></label>
<div class="clear"></div>
</div>
<div class="twk-password-meter">
<div class="twk-password-meter-bg">
<div class="twk-password-meter-bar"></div>
</div>
</div>
<div class="twk-password-meter-message"></div>
</div>
<div class="twk-button-container">
<input type="submit" id="twk-sumbit-btn" value="Request quote" class="wpcf7-form-control wpcf7-submit button button_filled button_large">
<div id="twk-submit-loader" class="twk-loader"></div>
</div>
</form>
<p id="twk-submit-message" class="twk-error"></p>
</div>
<script>
function myFunction() {
    document.getElementById("twk-signup-form").reset();
}
window.onload = myFunction;
</script>
</div><div class="column one column_divider"><hr style="margin: 0 auto 60px; border:none; width:0; height:0;"/>
</div></div></div></div><div class="section the_content"><div class="section_wrapper"><div class="the_content_wrapper"></div></div></div> </div>
 
</div>
</div>
 
<footer id="Footer" class="clearfix">
<div class="widgets_wrapper">
<div class="container">
<div class="one-third column"><aside id="nav_menu-2" class="widget widget_nav_menu"><h4>Product</h4><div class="menu-product-container"><ul id="menu-product" class="menu"><li id="menu-item-1646" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1646"><a href="features/index.html">Features</a></li>
<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="features/iphone-app/index.html">iPhone App</a></li>
<li id="menu-item-251" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-251"><a href="features/android-app/index.html">Android App</a></li>
<li id="menu-item-252" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-252"><a href="knowledgebase/integrations/index.html">Integrations</a></li>
<li id="menu-item-653" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-653"><a href="knowledgebase/index.html">Knowledgebase</a></li>
</ul></div></aside></div><div class="one-third column"><aside id="nav_menu-3" class="widget widget_nav_menu"><h4>About</h4><div class="menu-about-container"><ul id="menu-about" class="menu"><li id="menu-item-380" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-380"><a href="team/index.html">Mission & Vision</a></li>
<li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-35"><a href="blog/index.html">Blog</a></li>
<li id="menu-item-53" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-53"><a href="privacy-policy/index.html">Privacy Policy</a></li>
<li id="menu-item-817" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-817"><a href="terms-of-service/index.html">Terms of Service</a></li>
<li id="menu-item-315" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-315"><a href="join-the-team/index.html">Career</a></li>
</ul></div></aside></div><div class="one-third column"><aside id="text-3" class="widget widget_text"><h4>Connect and follow us on our various social media</h4> <div class="textwidget"><p>Try our messaging platform today.</p>
<div class="social">
<ul>
<li class="twitter"><a target="_blank" href="https://twitter.com/tawktotawk/" title="Twitter"><i class="icon-twitter"></i></a>
<li class="facebook"><a target="_blank" href="https://www.facebook.com/tawkto/" title="Facebook"><i class="icon-facebook"></i></a></li>
<li class="youtube"><a target="_blank" href="https://www.youtube.com/channel/UCmmsTnOAYjv1pZl-ueAMM-A" title="Youtube"><i class="icon-play"></i></a></li>
<li class="linked_in"><a target="_blank" href="https://www.linkedin.com/company/tawk-to" title="LinkedIn"><i class="icon-linkedin"></i></a></li>
</ul>
</div>
</div>
</aside></div>
</div>
</div>
<div class="footer_copy">
<div class="container">
<div class="column one">
<a id="back_to_top" href="#"><i class="icon-up-open-big"></i></a>
 
<div class="copyright">
© 2017 tawk.to inc. All Rights Reserved. </div>
 
<div class="social">
<ul>
</ul>
</div>
</div>
</div>
</div>
</footer>
</div>

<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>
