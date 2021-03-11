<template>
  <div class="page page-booth" data-name="agreemarketing">
    <div class="navbar navbar-new">
      <div class="navbar-bg"></div>
      <div class="navbar-inner sliding">
        <div class="left">
          <a href="#" class="link back">
            <i class="icon icon-back"></i>
            <span class="if-not-md">Back</span>
          </a>
        </div>
        <div class="title">마케팅 수신동의</div>

      </div>
    </div>
    <div class="page-content">
		<div class="agreemarketing_wrap">
			<div class="agreemarketing_inner">
				@include('mobile.inc.termsmarketting')		
			</div>
		</div>
		
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
  }
</script>
