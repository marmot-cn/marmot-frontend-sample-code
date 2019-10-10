<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>{#website_title#}</title>

  <link rel="shortcut icon" href="{#website_icon#}" type="image/x-icon">
  <link rel="icon" href="{#website_icon#}" type="image/x-icon">
  <!--样式表-->
  <link rel="stylesheet"
        href="https://qixinyun.oss-cn-beijing.aliyuncs.com/portal/plugin/layui/layui-2.4.3/css/layui.css">
  <link rel="stylesheet"
        href="https://qixinyun.oss-cn-beijing.aliyuncs.com/portal/plugin/bootstrap/bootstrap-3.3.7/css/bootstrap.min.css">
  <style>
    *, p, ul {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      padding: 0;
      margin: 0
    }

    html {
      font-size: 62.5%;
      min-height: 100%
    }

    body {
      width: 100%;
      min-height: 100%;
      font: 14px/1.8 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif;
      color: #333;
      position: relative;
      background: #f6f6f6;
      overflow-x: hidden
    }

    :focus {
      outline: 0
    }

    ol, ul {
      list-style: none
    }

    a {
      text-decoration: none;
      color: #333
    }

    a:focus, a:hover {
      text-decoration: none;
      color: #e22323;
      opacity: .8
    }

    table {
      border-spacing: 0
    }

    label {
      font-weight: 400;
      margin: 0
    }

    footer, header, nav, section {
      display: block;
      width: 100%
    }

    .floatLeft {
      float: left
    }

    .floatRight {
      float: right
    }

    .center {
      text-align: center
    }

    .ellipsis {
      display: block;
      white-space: nowrap;
      -o-text-overflow: ellipsis;
      text-overflow: ellipsis;
      overflow: hidden
    }

    .row {
      margin-left: 0;
      margin-right: 0
    }

    .spacer-zero {
      padding: 0
    }

    [type=reset], [type=submit], button {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none
    }

    .tab-click-sec {
      display: none
    }

    .tab-click-sec.active {
      display: block
    }

    .pop-up-layer {
      position: fixed;
      top: 150%;
      opacity: 0
    }

    section {
      padding: 20px 0
    }

    .search {
      max-width: 1000px;
      margin: 16% auto 0
    }

    .search .title {
      text-align: center;
      font-size: 36px;
      color: #e22323;
      margin-bottom: 40px
    }

    .search .search-box {
      border: 1px solid #ddd;
      background-color: #fff
    }

    .search .search-box .top {
      padding: 20px 30px;
      background-color: #e22323
    }

    .search .search-box .top a {
      display: inline-block;
      background-color: transparent;
      font-size: 16px
    }

    .search .search-box .top a.active {
      background-color: #fff;
      color: #e22323
    }

    .search .search-box .search-content {
      padding: 60px 100px
    }

    .search .search-box .search-content div {
      position: relative
    }

    .search .search-box .search-content div button {
      position: absolute;
      top: 0;
      right: 0;
      background-color: #e22323
    }

    .container {
      position: relative
    }

    .container a.download {
      position: absolute;
      top: 35px;
      right: 50px;
      background-color: #fff;
      color: #e22323;
      padding: 0 25px;
      z-index: 2
    }

    .score-show {
      background-color: #fff;
      padding: 25px
    }

    .score-show .score-show-top {
      padding: 25px;
      background: url(./images/score-bg.jpg) no-repeat center/cover #e22323;
      position: relative
    }

    .credit-rating-label {
      margin-top: 10px;
      padding: 0 10px;
      display: inline-block;
      height: 28px;
      line-height: 28px;
      background-color: #fff;
      border-radius: 2px;
      font-size: 14px;
      font-weight: 500;
      color: #e22323;
    }

    .credit-rating-label i {
      font-style: normal;
      font-weight: 600;
    }

    .score-show .score-show-top .box {
      width: 210px;
      margin: auto;
      position: relative;
      color: #fff;
      text-align: center
    }

    .score-show .score-show-top .box > div {
      position: absolute;
      left: 0;
      top: 32%;
      width: 100%
    }

    .score-show .score-show-top .box div p {
      font-size: 48px;
      font-weight: 700;
      line-height: 1.2
    }

    .score-show .score-show-top .box div span {
      font-size: 16px
    }

    .score-show .score-show-top .box > p {
      margin-top: 12px;
      font-size: 16px;
      line-height: 1.2
    }

    .score-show .attach {
      font-size: 16px;
      font-weight: 700;
      color: #e22323;
      margin-top: 20px
    }

    .score-show .score-show-item {
      margin-top: 20px
    }

    .score-show .score-show-item .item-top {
      border: 1px solid #ddd;
      margin-bottom: 20px
    }

    .score-show .score-show-item .item-top p {
      display: inline-block;
      background-color: #e22323;
      padding: 8px 15px;
      color: #fff;
      font-size: 16px;
      font-weight: 700
    }

    .score-show .score-show-item .item-top p span {
      font-size: 14px;
      font-weight: 400
    }

    .score-show .score-show-item .item-box .table {
      margin-bottom: 0
    }

    .score-show .score-show-item .item-box .table td {
      padding: 20px;
      font-size: 16px
    }

    .score-show .score-show-item .item-box .layui-timeline-axis {
      left: -2px;
      width: 15px;
      height: 15px;
      background-color: #e22323
    }

    .score-show .score-show-item .item-box .layui-timeline-item:before, .score-show .score-show-item .item-box hr {
      background-color: #e22323
    }

    h3 {
      margin-top: 0;
    }

    h3 span {
      display: inline-block;
      vertical-align: middle;
      font-size: 14px;
      color: #e22323;
      margin-left: 20px;
    }

    .layui-timeline-content > div {
      margin-left: -15px;
      margin-right: -15px;
    }

    .basis li {
      padding: 5px 0;
    }

    @media screen and (max-width: 767px) {
      .score-show {
        padding: 5px 10px;
      }

      .container a.download {
        top: 15px;
        right: 35px;
      }
    }
  </style>
</head>
<body>

<section>
  <div class="container">
    <div class="score-show" id="download">
      <div class="score-show-box">
        <div class="score-show-item">
          <div class="item-box">
            <ul class="row basis">
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>标题:{if !empty($news['title'])}{$news['title']}{/if}</p>
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>来源:{if
                  !empty($news['source'])}{$news['source']}{/if}</p>
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>内容:{if
                  !empty($news['content'])}{$news['content']}{/if}</p>
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>图片地址:{if
                  !empty($news['image']['identify'])}{$news['image']['identify']}{/if}</p>
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
               {foreach $news['attachments'] as $attachment}
                <p>附件地址:{if
                  !empty($attachment['identify'])}{$attachment['identify']}{/if}</p>
               {/foreach}
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>委办局名称:{if !empty($news['publishUserGroup']['name'])}{$news['publishUserGroup']['name']}{/if}</p>
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>状态:{if !empty($news['status'])}{$news['status']}{/if}</p>
              </li>
              <li class="col-xs-12 col-sm-6 col-lg-4">
                <p>更新时间:{if !empty($news['updateTime'])}{$news['updateTime']}{/if}</p>
              </li>
            </ul>
          </div> 
        </div>

      </div>
    </div>
  </div>
</section>
</body>
</html>