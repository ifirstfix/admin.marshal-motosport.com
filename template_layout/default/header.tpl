<style type="text/css">
  .logo-main:hover {
      opacity: 0.5;
      color: unset;
      text-decoration: unset;
  }
</style>

<header class="navbar navbar-expand-md navbar-dark d-print-none">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3">
      <a class='logo-main' href="<?=WEB_META_BASE_URL?>">
        <img src="<?=WEB_META_BASE_URL?>images/logo.png" width="110" height="32" alt="Tabler" class="navbar-brand-image">
      </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
      <div class="nav-item dropdown px-3">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url(<?=WEB_META_BASE_URL?>images/face28.jpg)"></span>
          <div class="d-none d-xl-block ps-2">
            <div><?=$_SESSION['user_name']?></div>
            <div class="mt-1 small text-muted"><?=$_SESSION['email']?></div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a id="sign_out" class="dropdown-item cursor-pointer">Logout</a>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url(<?=WEB_META_BASE_URL?>images/baht.png)"></span>
          <div class="d-none d-xl-block ps-2">
            <div>THB to USD</div>
            <div id="currency_text" class="mt-1 small text-muted"><?=currency()?></div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <input id="currency_thb" type="text" value="<?=currency()?>" class="form-control">
          <button id="currency" class="btn btn-success btn-sm w-100">Change</button>
        </div>
      </div>

    </div>
  </div>
</header>