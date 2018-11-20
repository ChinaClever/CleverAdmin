define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mp/devinfo/index',
                    add_url: 'mp/devinfo/add',
                    edit_url: 'mp/devinfo/edit',
                    del_url: 'mp/devinfo/del',
                    multi_url: 'mp/devinfo/multi',
                    table: 'mp_devinfo',
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
                        {field: 'dev.barcode', title: __('Dev.barcode'), formatter:Table.api.formatter.search},
                        {field: 'df', title: __('Df')},
                        {field: 'line', title: __('Line')},
                        {field: 'loop', title: __('Loop')},
                        {field: 'output', title: __('Output')},
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