<div class="orders">
    <style scoped>
        .item-close{
            color: green;
        }
    </style>
    <div class="caption">
        <h2>~ Назначенные заказы ({{time}}) ~</h2>
    </div>
    <div class="order" ng-if="!data.length">Назначенных заказов на это время нет<br><br></div>
    <div class="order" ng-repeat="item in data">
        <i>{{item.orderTime}}</i>
        <span class="order__name">{{item.name}}</span>
        <span class="order__phone">{{item.phone}}</span>
        <span class="order__date">{{item.date}}</span>
        <i ng-class="{'order__date': true, 'item-close': item.status == 'close'}">{{item.status == 'close' ? 'Подтвержден' : 'Ожидание'}}</i>
        <div class="">
            <div ng-if="item.status != 'close'" class="btn btn-default btn-order" ng-click="accept(item.id)">Подтвердить</div>
            <div class="btn btn-default btn-order" ng-click="setTime(item.id)">Назначить время</div>
            <div class="btn btn-default btn-order" ng-click="remove(item.id)">Удалить</div>
        </div>
        <hr>
    </div>
    <div class="btn btn-default" ng-click="add(time)">Добавить новый</div>
    </div>
</div>