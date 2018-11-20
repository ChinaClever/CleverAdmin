define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'mp/dev/index',
                    add_url: 'mp/dev/add',
                    edit_url: 'mp/dev/edit',
                    del_url: 'mp/dev/del',
                    multi_url: 'mp/dev/multi',
                    table: 'mp_dev',
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
                        {field: 'devtype', title: __('Devtype'),formatter: Controller.api.formatter.browser },

                        // {field: 'devtype', title: __('Devtype'), searchList: {"M-PDU":__('M-pdu'),"Z-PDU":__('Z-pdu'),"IP-PDU":__('Ip-pdu'),"SI-PDU":__('Si-pdu')}, formatter: Table.api.formatter.normal},
                        {field: 'sn', title: __('Sn'), formatter: Controller.api.formatter.sn},
                        {field: 'barcode', title: __('Barcode'), formatter:Table.api.formatter.search},
                        {field: 'purpose', title: __('Purpose')},
                        {field: 'batch', title: __('Batch')},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"deleted":__('Deleted')}, formatter: Table.api.formatter.status},
                        {field: 'testdate', title: __('Testdate'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'op', title: __('Op'), visible:false},
                        {field: 'cn', title: __('Cn'), visible:false},
                        {field: 'createtime', title: __('Createtime'), visible:false, operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                      //  {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}

                        //操作栏,默认有编辑、删除或排序按钮,可自定义配置buttons来扩展按钮
                        {
                            field: 'operate',
                            width: "120px",
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'detail',
                                    title: __('测试项目数量'),
                                    classname: 'btn btn-xs btn-primary btn-dialog',
                                    icon: 'fa fa-list',
                                    url: 'mp/itemnum/detail',
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }


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
            },
            formatter: {
                sn: function (value, row, index) {
                    //这里手动构造URL
                    url = "mp/record?dev." + this.field + "=" + value;

                    //方式一,直接返回class带有addtabsit的链接,这可以方便自定义显示内容
                    return '<a href="' + url + '" class="label label-success addtabsit" title="' + __("SN: %s", value) + '">' + value + '</a>';

                    //方式二,直接调用Table.api.formatter.addtabs
                    // return Table.api.formatter.addtabs(value, row, index, url);
                },
                browser: function (value, row, index) {
                    url = "mp/devinfo/detail?ids=" + row.id;

                    //方式一,直接返回class带有addtabsit的链接,这可以方便自定义显示内容
                    return '<a href="' + url + '" class="btn btn-xs btn-dialog" title="' + __("%s", value) + '">' + __('%s', value) + '</a>';
                }
            }
        }
    };
    return Controller;
});