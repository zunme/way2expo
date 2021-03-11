<template>
<div class="page">
  <div class="navbar">
    <div class="navbar-bg"></div>
    <div class="navbar-inner sliding">
      <div class="left">
        <a href="#" class="link back">
          <i class="icon icon-back"></i>
          <span class="if-not-md">Back</span>
        </a>
      </div>
      <div class="title"></div>
    </div>
  </div>
  <div class="page-content">
    <div class="block block-strong">
      <p>Sorry</p>
      @if ( isset($msg) && !empty($msg) )
      <p>{!! $msg !!}</p>
      @else
      <p>Requested content not found.</p>
      @endif
    </div>
  </div>
</div>
</template>
<script>
  return {
    data: function () {
      return {
      }
    },
    methods: {

    },
    on: {
      pageBeforeRemove: function () {
        var self = this;
        // Destroy popup when page removed
        if (self.notificationFull) self.notificationFull.destroy();
        if (self.popup) self.popup.destroy();
        if (self.popupSwipe) self.popupSwipe.destroy();
        if (self.popupSwipeHandler) self.popupSwipeHandler.destroy();
        if (self.popupPush) self.popupPush.destroy();
      },
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
      },
    }
  }
</script>
