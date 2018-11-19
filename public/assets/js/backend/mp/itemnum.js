define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mp/itemnum/index',
                    add_url: 'mp/itemnum/add',
                    edit_url: 'mp/itemnum/edit',
                    del_url: 'mp/itemnum/del',
                    multi_url: 'mp/itemnum/multi',
                    table: 'mp_itemnum',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'dev.devtype', title: __('Dev.devtype')},
                        {field: 'dev.sn', title: __('Dev.sn')},
                        {field: 'dev.barcode', title: __('Dev.barcode')},

                        {field: 'all', title: __('All')},
                        {field: 'finish', title: __('Finish')},
                        {field: 'pass', title: __('Pass')},
                        {field: 'err', title: __('Err')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});