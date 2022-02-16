@extends('layouts.admin')
@section('content')
{{-- <div class="content">
    <div class="row">
        <div class="col-lg-12">
            Home
        </div>
    </div>
</div> --}}
<div class="content">
        <div class="container-fluid">

          

    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">people_alt</i>
            </div>
            <p class="card-category">Users</p>
            <h3 class="card-title">{{$users}}
              {{-- <small>GB</small> --}}
            </h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">people_alt</i>
              <a href="{{route('admin.users.index')}}">All users</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">store</i>
            </div>
            <p class="card-category">Revenue</p>
            <h3 class="card-title"> ${{number_format($revenue, 2)}}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">monetization_on</i> 
              <a href="{{route('admin.purchased-plans')}}">Total Revenue</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">inventory_2</i>
            </div>
            <p class="card-category">Total Products</p>
            <h3 class="card-title">{{$total_products}} Items</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">inventory_2</i> 
              <a href="{{route('admin.products.index')}}">Total Products List</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">flag</i>
            </div>
            <p class="card-category">Reports</p>
            <h3 class="card-title">{{$reports}}</h3>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">update</i> Just Updated
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="row">
      <div class="col-md-4">
        <div class="card card-chart">
          <div class="card-header card-header-success">
            <div class="ct-chart" id="dailySalesChart"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-line" style="width: 100%; height: 100%;"><g class="ct-grids"><line x1="40" x2="40" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="76.18973214285714" x2="76.18973214285714" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="112.37946428571429" x2="112.37946428571429" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="148.56919642857144" x2="148.56919642857144" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="184.75892857142858" x2="184.75892857142858" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="220.94866071428572" x2="220.94866071428572" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="257.1383928571429" x2="257.1383928571429" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line y1="120" y2="120" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><path d="M40,91.2C76.19,79.2,76.19,79.2,76.19,79.2C112.379,103.2,112.379,103.2,112.379,103.2C148.569,79.2,148.569,79.2,148.569,79.2C184.759,64.8,184.759,64.8,184.759,64.8C220.949,76.8,220.949,76.8,220.949,76.8C257.138,28.8,257.138,28.8,257.138,28.8" class="ct-line"></path><line x1="40" y1="91.2" x2="40.01" y2="91.2" class="ct-point" ct:value="12" opacity="1"></line><line x1="76.18973214285714" y1="79.2" x2="76.19973214285714" y2="79.2" class="ct-point" ct:value="17" opacity="1"></line><line x1="112.37946428571429" y1="103.2" x2="112.3894642857143" y2="103.2" class="ct-point" ct:value="7" opacity="1"></line><line x1="148.56919642857144" y1="79.2" x2="148.57919642857144" y2="79.2" class="ct-point" ct:value="17" opacity="1"></line><line x1="184.75892857142858" y1="64.8" x2="184.76892857142857" y2="64.8" class="ct-point" ct:value="23" opacity="1"></line><line x1="220.94866071428572" y1="76.8" x2="220.9586607142857" y2="76.8" class="ct-point" ct:value="18" opacity="1"></line><line x1="257.1383928571429" y1="28.799999999999997" x2="257.1483928571429" y2="28.799999999999997" class="ct-point" ct:value="38" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="36.189732142857146" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">M</span></foreignObject><foreignObject style="overflow: visible;" x="76.18973214285714" y="125" width="36.189732142857146" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">T</span></foreignObject><foreignObject style="overflow: visible;" x="112.37946428571429" y="125" width="36.18973214285715" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">W</span></foreignObject><foreignObject style="overflow: visible;" x="148.56919642857144" y="125" width="36.18973214285714" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">T</span></foreignObject><foreignObject style="overflow: visible;" x="184.75892857142858" y="125" width="36.18973214285714" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">F</span></foreignObject><foreignObject style="overflow: visible;" x="220.94866071428572" y="125" width="36.18973214285717" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">S</span></foreignObject><foreignObject style="overflow: visible;" x="257.1383928571429" y="125" width="36.18973214285711" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 36px; height: 20px;">S</span></foreignObject><foreignObject style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject><foreignObject style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">10</span></foreignObject><foreignObject style="overflow: visible;" y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">20</span></foreignObject><foreignObject style="overflow: visible;" y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">30</span></foreignObject><foreignObject style="overflow: visible;" y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">40</span></foreignObject><foreignObject style="overflow: visible;" y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">50</span></foreignObject></g></svg></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Daily Sales</h4>
            <p class="card-category">
              <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i> updated 4 minutes ago
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-chart">
          <div class="card-header card-header-warning">
            <div class="ct-chart" id="websiteViewsChart"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"><line y1="120" y2="120" x1="40" x2="288.328125" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="288.328125" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="288.328125" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="288.328125" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="288.328125" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="288.328125" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><line x1="50.347005208333336" x2="50.347005208333336" y1="120" y2="54.959999999999994" class="ct-bar" ct:value="542" opacity="1"></line><line x1="71.041015625" x2="71.041015625" y1="120" y2="66.84" class="ct-bar" ct:value="443" opacity="1"></line><line x1="91.73502604166667" x2="91.73502604166667" y1="120" y2="81.6" class="ct-bar" ct:value="320" opacity="1"></line><line x1="112.42903645833333" x2="112.42903645833333" y1="120" y2="26.400000000000006" class="ct-bar" ct:value="780" opacity="1"></line><line x1="133.123046875" x2="133.123046875" y1="120" y2="53.64" class="ct-bar" ct:value="553" opacity="1"></line><line x1="153.81705729166669" x2="153.81705729166669" y1="120" y2="65.64" class="ct-bar" ct:value="453" opacity="1"></line><line x1="174.51106770833334" x2="174.51106770833334" y1="120" y2="80.88" class="ct-bar" ct:value="326" opacity="1"></line><line x1="195.20507812500003" x2="195.20507812500003" y1="120" y2="67.92" class="ct-bar" ct:value="434" opacity="1"></line><line x1="215.89908854166669" x2="215.89908854166669" y1="120" y2="51.84" class="ct-bar" ct:value="568" opacity="1"></line><line x1="236.59309895833334" x2="236.59309895833334" y1="120" y2="46.8" class="ct-bar" ct:value="610" opacity="1"></line><line x1="257.287109375" x2="257.287109375" y1="120" y2="29.28" class="ct-bar" ct:value="756" opacity="1"></line><line x1="277.9811197916667" x2="277.9811197916667" y1="120" y2="12.599999999999994" class="ct-bar" ct:value="895" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="20.694010416666668" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">J</span></foreignObject><foreignObject style="overflow: visible;" x="60.69401041666667" y="125" width="20.694010416666668" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">F</span></foreignObject><foreignObject style="overflow: visible;" x="81.38802083333334" y="125" width="20.694010416666664" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">M</span></foreignObject><foreignObject style="overflow: visible;" x="102.08203125" y="125" width="20.69401041666667" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">A</span></foreignObject><foreignObject style="overflow: visible;" x="122.77604166666667" y="125" width="20.69401041666667" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">M</span></foreignObject><foreignObject style="overflow: visible;" x="143.47005208333334" y="125" width="20.694010416666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">J</span></foreignObject><foreignObject style="overflow: visible;" x="164.1640625" y="125" width="20.694010416666686" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">J</span></foreignObject><foreignObject style="overflow: visible;" x="184.85807291666669" y="125" width="20.694010416666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">A</span></foreignObject><foreignObject style="overflow: visible;" x="205.55208333333334" y="125" width="20.694010416666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">S</span></foreignObject><foreignObject style="overflow: visible;" x="226.24609375" y="125" width="20.694010416666686" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">O</span></foreignObject><foreignObject style="overflow: visible;" x="246.94010416666669" y="125" width="20.694010416666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 21px; height: 20px;">N</span></foreignObject><foreignObject style="overflow: visible;" x="267.63411458333337" y="125" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">D</span></foreignObject><foreignObject style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject><foreignObject style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">200</span></foreignObject><foreignObject style="overflow: visible;" y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">400</span></foreignObject><foreignObject style="overflow: visible;" y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">600</span></foreignObject><foreignObject style="overflow: visible;" y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">800</span></foreignObject><foreignObject style="overflow: visible;" y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">1000</span></foreignObject></g></svg></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Email Subscriptions</h4>
            <p class="card-category">Last Campaign Performance</p>
          </div>
           <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i> campaign sent 2 days ago
            </div>
          </div> 
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-chart">
          <div class="card-header card-header-danger">
            <div class="ct-chart" id="completedTasksChart"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-line" style="width: 100%; height: 100%;"><g class="ct-grids"><line x1="40" x2="40" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="71.666015625" x2="71.666015625" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="103.33203125" x2="103.33203125" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="134.998046875" x2="134.998046875" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="166.6640625" x2="166.6640625" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="198.330078125" x2="198.330078125" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="229.99609375" x2="229.99609375" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="261.662109375" x2="261.662109375" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line y1="120" y2="120" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="293.328125" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><path d="M40,92.4C71.666,30,71.666,30,71.666,30C103.332,66,103.332,66,103.332,66C134.998,84,134.998,84,134.998,84C166.664,86.4,166.664,86.4,166.664,86.4C198.33,91.2,198.33,91.2,198.33,91.2C229.996,96,229.996,96,229.996,96C261.662,97.2,261.662,97.2,261.662,97.2" class="ct-line"></path><line x1="40" y1="92.4" x2="40.01" y2="92.4" class="ct-point" ct:value="230" opacity="1"></line><line x1="71.666015625" y1="30" x2="71.676015625" y2="30" class="ct-point" ct:value="750" opacity="1"></line><line x1="103.33203125" y1="66" x2="103.34203125" y2="66" class="ct-point" ct:value="450" opacity="1"></line><line x1="134.998046875" y1="84" x2="135.008046875" y2="84" class="ct-point" ct:value="300" opacity="1"></line><line x1="166.6640625" y1="86.4" x2="166.6740625" y2="86.4" class="ct-point" ct:value="280" opacity="1"></line><line x1="198.330078125" y1="91.2" x2="198.340078125" y2="91.2" class="ct-point" ct:value="240" opacity="1"></line><line x1="229.99609375" y1="96" x2="230.00609375" y2="96" class="ct-point" ct:value="200" opacity="1"></line><line x1="261.662109375" y1="97.2" x2="261.672109375" y2="97.2" class="ct-point" ct:value="190" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">12p</span></foreignObject><foreignObject style="overflow: visible;" x="71.666015625" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">3p</span></foreignObject><foreignObject style="overflow: visible;" x="103.33203125" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">6p</span></foreignObject><foreignObject style="overflow: visible;" x="134.998046875" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">9p</span></foreignObject><foreignObject style="overflow: visible;" x="166.6640625" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">12p</span></foreignObject><foreignObject style="overflow: visible;" x="198.330078125" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">3a</span></foreignObject><foreignObject style="overflow: visible;" x="229.99609375" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">6a</span></foreignObject><foreignObject style="overflow: visible;" x="261.662109375" y="125" width="31.666015625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 32px; height: 20px;">9a</span></foreignObject><foreignObject style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject><foreignObject style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">200</span></foreignObject><foreignObject style="overflow: visible;" y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">400</span></foreignObject><foreignObject style="overflow: visible;" y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">600</span></foreignObject><foreignObject style="overflow: visible;" y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">800</span></foreignObject><foreignObject style="overflow: visible;" y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">1000</span></foreignObject></g></svg></div>
          </div>
          <div class="card-body">
            <h4 class="card-title">Completed Tasks</h4>
            <p class="card-category">Last Campaign Performance</p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i> campaign sent 2 days ago
            </div>
          </div> 
        </div>
      </div>
    </div> --}}
    <div class="row">
      <div class="col-lg-5 col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">Recent Subscription</h4>
            {{-- <p class="card-category">New employees on 15th September, 2016</p> --}}
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($plan_payments as $key => $payment)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$payment->user->name}}</td>
                  <td>${{$payment->amount}}</td>
                  <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y')}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-7 col-md-12">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">Recent Products</h4>
            {{-- <p class="card-category">New employees on 15th September, 2016</p> --}}
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <tr>
                  <th>ID</th>
                  <th>Product</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $key => $product)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$product->name}}</td>
                  <td>$ {{$product->price}}</td>
                  <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y')}}</td>
                  <td><a class="btn btn-xs btn-info" href="{{route('admin.products.edit', $product->id)}}">Edit</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>



        </div>
      </div>
@endsection
@section('scripts')
@parent

@endsection