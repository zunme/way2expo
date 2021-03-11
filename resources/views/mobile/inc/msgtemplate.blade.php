<template>

  <div class="page no-toolbar no-navbar no-swipeback login-screen-page">
    <div class="login-close-btn" style="position:absolute;right: 10px;top: 10px;">
      <a href="#" class="link back" style="font-size: 30px;color: #666;">
        <i class="material-icons">close</i>
      </a>
    </div>
    <div class="page-content login-screen-content">

      <div class="login-screen-title">
        <div class="login-brand">
          <img src="/image/fav180.png" alt="logo" width="100" class="shadow-light " style="background-color: #ffffff;box-shadow: 0 5px 8px #c3d5e4;border-radius:50%;">
        </div>
        <div style="font-size: 14px;color: #6d6d6d;margin-top: 10px;">
          {!! $msg !!}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  return {
    methods: {
    }
  }
</script>
