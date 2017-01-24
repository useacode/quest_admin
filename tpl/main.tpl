<div class="price">
    <style scoped>
        .item-wait{
            background-color: #339;
        }
        .item-close{
            background-color: #393;
        }
        .item-multi{
            background-color: #E33;
        }
    </style>
    <div class="price__caption">
        <h2>~ График ~</h2>
    </div>
    <div class="times">

        <div class="row-time-wrap">           

            <div class="col-time-left  col-time-left--top">
                <div class="row-time" ng-repeat="item in data">
                    <div class="day">{{item.date}} <p>({{item.weekDay}})</p></div>
                    
                    <div ng-repeat="time in item.times" ng-class="{'time': true, 'item-wait': time.status == 'wait', 'item-multi': time.status == 'multi', 'item-close': time.status == 'close'}" title="{{getTitle(time.status)}}" ng-click="select(time.fullTime)" >{{time.time}}</div>
                </div>
        </div>
    </div>
    <div class="week-buttons">
        <a ng-repeat="i in [0, 1, 2]" ng-class="{'next-week': true, 'active': i == num}" href ng-click="getData(i)">{{i+1}}</a>
    </div>
    
</div>