define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mp/record/index',
                    add_url: 'mp/record/add',
                    edit_url: 'mp/record/edit',
                    del_url: 'mp/record/del',
                    multi_url: 'mp/record/multi',
                    table: 'mp_record',
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
                        {field: 'id', title: __('Id'), visible:false},
                        {field: 'uid', title: __('Uid')},
                        {field: 'dev.devtype', title: __('Dev.devtype')},
                        {field: 'dev.sn', title: __('Dev.sn')},
                        {field: 'dev.barcode', title: __('Dev.barcode')},
                        {field: 'testitem', title: __('Testitem')},
                        {field: 'describe', title: __('Describe')},
                        {field: 'expect', title: __('Expect')},
                        {field: 'measured', title: __('Measured')},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"deleted":__('Deleted')}, formatter: Table.api.formatter.status},
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