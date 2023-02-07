<div id="toast-container"></div>
<div class="page">
	<div class="sticky-top">
		<?php include $theme_dir . "header.tpl"; ?>    

		<div class="navbar-expand-md">
		  <div class="collapse navbar-collapse" id="navbar-menu">
		    <div class="navbar navbar-light">
		      <div class="container-xl">
					<ul class="navbar-nav">
						<?php if ($_SESSION['group'] == '3') {  ?>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>product">
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-shopping-basket" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Product</span>
								</a>
							</li>
						<?php } ?>

						<?php if ($_SESSION['group'] == '2') {  ?>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>news" >
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-newspaper" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">News</span>
								</a>
							</li>
						<?php } ?>

						<?php if ($_SESSION['isAdmin'] == true) {  ?>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>order">
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-cart-plus" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Order</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>product">
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-shopping-basket" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Product</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>delivery">
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-shipping-fast" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Delivery</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>news" >
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-newspaper" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">News</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>member" >
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-chalkboard-teacher" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Member Registered</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG?>gallery">
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-images" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Services</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG?>about">
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-id-card-alt" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">About</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?=WEB_META_BASE_LANG ; ?>banner" >
									<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-th-large" style="margin: 1px 5px 0px 0px;"></i>
									<span class="nav-link-title">Banner</span>
								</a>
							</li>
						<?php } ?>
					</ul>
					<ul class="navbar-nav">
						<?php if ($_SESSION['isAdmin'] == true) {  ?>
						<li class="nav-item">
							<a class="nav-link" href="<?=WEB_META_BASE_LANG?>employee">
								<i class="nav-link-icon d-md-none d-lg-inline-block fas fa-users-cog" style="margin: 1px 5px 0px 0px;"></i>
								<span class="nav-link-title">Employee</span>
							</a>
						</li>
						<?php } ?>
					</ul>
		      </div>
		    </div>
		  </div>
		</div>
		
  	</div>

	<div class="content">
		<?=$HTML_CONTENT?>
		<?php include $theme_dir . "footer.tpl";?>
	</div>
</div>
