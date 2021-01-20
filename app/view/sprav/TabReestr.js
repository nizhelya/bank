/*
 * File: app/view/sprav/TabReestr.js
 * Date: Thu May 28 2015 19:53:22 GMT+0300 (EEST)
 *
 * This file was generated by Sencha Architect version 3.2.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 5.1.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 5.1.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('Bank.view.sprav.TabReestr', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.tabreestr',

    requires: [
        'Bank.view.sprav.TabReestrViewModel',
        'Bank.view.sprav.TabReestrViewController',
        'Ext.grid.Panel',
        'Ext.view.Table',
        'Ext.grid.column.Number',
        'Ext.grid.column.Date',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Number',
        'Ext.grid.feature.GroupingSummary',
        'Ext.grid.plugin.CellEditing'
    ],

    controller: 'tabReestr',
    viewModel: {
        type: 'tabReestr'
    },
    hidden: true,
    id: 'tabReestr',
    scrollable: true,
    layout: 'fit',
    title: 'Реестр',

    items: [
        {
            xtype: 'gridpanel',
            id: 'grReestr',
            scrollable: true,
            width: 522,
            title: 'Редактированние реестра по квартире',
            store: 'StReestr',
            columns: [
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    width: 70,
                    dataIndex: 'nom',
                    text: 'Номер'
                },
                {
                    xtype: 'gridcolumn',
                    width: 74,
                    dataIndex: 'nomer',
                    menuDisabled: true,
                    text: 'п/н'
                },
                {
                    xtype: 'datecolumn',
                    dataIndex: 'data',
                    menuDisabled: true,
                    text: 'Дата',
                    format: 'd-m-Y'
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                        return Ext.String.format('<div class="topic"><b>{0}</b><span class="author">{1}</span></div>', value, record.get('fio') || "Unknown");
                    },
                    width: 134,
                    dataIndex: 'address',
                    text: 'Плательщик'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    width: 60,
                    dataIndex: 'address_id',
                    text: 'идА'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    renderData: {
                        tpl: [
                            '<p>Name: {name}</p>',
                            '<p>Company: {company}</p>',
                            '<p>Location: {city}, {state}</p>'
                        ]
                    },
                    width: 126,
                    dataIndex: 'fio',
                    menuDisabled: true,
                    text: 'ФИО'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'inn',
                    text: 'Инн'
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                        metaData.style = 'white-space:pre-wrap;';
                        return Ext.String.format('<div class="topic"> <b>{0}</b><span class="author">банк {1} </span><br><span class="author">МФО {2}</span><br><span class="author">ЕДРПУ {3} </span><br><span class="author">р.с {4} </span></div>',
                        value,
                        record.get('bank') || "",
                        record.get('mfo') || "",
                        record.get('okpo') || "",
                        record.get('account') || "");
                    },
                    width: 253,
                    dataIndex: 'client',
                    menuDisabled: true,
                    text: 'Клиент'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'bank',
                    text: 'Банк'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'account',
                    text: 'Счет',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'okpo',
                    text: 'Окпо',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'mfo',
                    text: 'Мфо',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    summaryType: 'sum',
                    width: 78,
                    align: 'right',
                    dataIndex: 'summa',
                    menuDisabled: true,
                    text: 'Сумма'
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                        metaData.style = 'white-space:pre-wrap;';
                        return value;
                    },
                    width: 142,
                    dataIndex: 'detali',
                    menuDisabled: true,
                    text: 'Детали платежа'
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {

                        var pr = '';
                        switch (value) {
                            case 'D':
                            pr ='Дневная';
                            break;
                            case 'W':
                            pr ='Вечерняя';
                            break;
                        }
                        return pr;
                    },
                    width: 93,
                    dataIndex: 'pr',
                    menuDisabled: true,
                    text: 'Касса',
                    editor: {
                        xtype: 'combobox',
                        displayField: 'kassa',
                        forceSelection: true,
                        queryMode: 'local',
                        store: 'StPriznak',
                        valueField: 'pr'
                    }
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                        return Ext.String.format('<div class="topic" > <b>{0}</b><span class="author">{1} </span><br><span class="author">{2}</span></div>',
                        value,
                        record.get('operator') || "",
                        record.get('data_in') || "");
                    },
                    width: 160,
                    dataIndex: 'otdel',
                    menuDisabled: true,
                    text: 'Отделение'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'oaccount',
                    text: 'Счет',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'taccount',
                    text: 'Тсчет',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'otdel_id',
                    text: 'идО',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'userl_id',
                    text: 'идЮ',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'kod',
                    text: 'Код',
                    format: '0'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    width: 133,
                    dataIndex: 'operator',
                    text: 'Оператор'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    width: 200,
                    dataIndex: 'data_in',
                    text: 'Время операциии'
                },
                {
                    xtype: 'numbercolumn',
                    width: 41,
                    dataIndex: 'out',
                    menuDisabled: true,
                    text: '=>',
                    format: '0',
                    editor: {
                        xtype: 'numberfield',
                        hideTrigger: true,
                        decimalPrecision: 0
                    }
                }
            ],
            features: [
                {
                    ftype: 'groupingsummary'
                }
            ],
            plugins: [
                {
                    ptype: 'cellediting',
                    listeners: {
                        edit: 'onCellEditingEdit'
                    }
                }
            ]
        }
    ]

});