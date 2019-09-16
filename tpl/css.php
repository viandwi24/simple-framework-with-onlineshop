<?php Template::get('bootstrap_css'); ?>
<style>
body {
  background-color: #f5f5f5;
  font-family: sans-serif;
  font-size: 0.9rem;
  line-height: 1.5;
}

a {
  transition: 0.3s;
}

.card {
  overflow: hidden;
  box-shadow: 0 3px 17px rgba(0, 0, 0, 0.15), 0 0 5px rgba(0, 0, 0, 0.15);
}
.card img {
  width: 100%;
  height: auto !important;
}

.add-to-cart {
  display: block;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  text-align: center;
  font-size: 1.3rem;
  line-height: 59px;
  position: absolute;
  right: 1.25rem;
  top: -30px;
  box-shadow: 0 2px 7px rgba(0, 0, 0, 0.4);
}
.add-to-cart:hover {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
}

.labels {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  opacity: 0.8;
}
.labels > div {
  width: 150px;
  position: absolute;
}
.labels > div.label-new {
  left: -40px;
  top: 20px;
  transform: rotate(-45deg);
}
.labels > div.label-sale {
  right: -40px;
  top: 20px;
  transform: rotate(45deg);
}

nav.navbar {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}


</style>