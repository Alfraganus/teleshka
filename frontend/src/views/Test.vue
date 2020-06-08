<template>
  <div>
    <div class="diag">
      <div class="block1 red"></div>
      <div class="block2 blue"></div>
      <div class="block3 teal"></div>
      <div class="block4 pink"></div>
    </div>
  </div>
</template>

<style scoped>
  .diag{
    width: 200px;
    height: 200px;
    position: relative;
    margin: 150px auto;
  }
  .block1{
    width: 200px;
    height: 100px;
    position: absolute;
    border-top-left-radius: 100px;
    border-top-right-radius: 100px;
    transform: rotate(30deg);
    transform-origin: bottom;
  }
  .block2{
    width: 100px;
    height: 100px;
    position: absolute;
    right: 0;
    border-top-right-radius: 100px;
    transform: rotate(240deg);
    transform-origin: left bottom;
  }
  .block3{
    width: 100px;
    height: 100px;
    position: absolute;
    bottom: 0;
    border-bottom-left-radius: 100px;
    transform: rotate(0deg);
    transform-origin: right top;
  }
  .block4{
    width: 100px;
    height: 100px;
    position: absolute;
    bottom: 0px;
    right: 0px;
    border-bottom-right-radius: 100px;
  }
</style>