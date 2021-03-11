<template>
  <div class="page page-booth" data-name="redirecthome">
    <div class="page-content">
		
    </div><!-- / page-content -->


  </div><!-- / page -->
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
      pageInit: function () {
        var self = this;
        var today = new Date();
        var app = self.$app;
		window.location.replace('/');
      },
    }
  }
</script>
