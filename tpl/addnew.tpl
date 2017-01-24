<div class="orders">
<div class="caption">
    <h2>~ Новый заказ ({{time}}) ~</h2>
<div class="form-group">
    <label for="name">Имя</label>
    <input id="name" type="text" class="form-control" ng-model="data.name">
    <br>
    <label for="phone">Телефон</label>
    <input id="phone" type="text" class="form-control" ng-model="data.phone">
    <br>
    <label for="status">Статус</label>
    <select id="status" type="text" class="form-control" ng-model="data.status">
        <option value="wait">Ожидание</option>
        <option value="close">Подтвержден</option>
    </select>
</div>
<div class="btn btn-default" ng-click="add()">Подтвердить</div>
</div>