<div class="orders">
<div class="caption">
    <h2>~ Новые заказы ~</h2>
</div>
<div class="order" ng-if="!data.length">Новых заказов нет</div>
<div class="order" ng-repeat="item in data">
    <i>{{item.orderTime}}</i>
    <span class="order__name">{{item.name}}</span>
    <span class="order__phone">{{item.phone}}</span>
    <span class="order__date">{{item.date}}</span>
    <div class="">
        <div class="btn btn-default btn-order" ng-click="accept(item.id)">Подтвердить</div>
        <div class="btn btn-default btn-order" ng-click="setTime(item.id)">Назначить время</div>
        <div class="btn btn-default btn-order" ng-click="remove(item.id)">Удалить</div>
    </div>
    <hr>
</div>
</div>