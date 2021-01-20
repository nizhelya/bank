/*
 * File: app/view/menu/TabPnLeft.js
 * Date: Fri May 29 2020 12:58:04 GMT+0300 (EEST)
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

Ext.define('Bank.view.menu.TabPnLeft', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.tabpnleft',

    requires: [
        'Bank.view.menu.TabPnLeftViewModel',
        'Ext.tab.Tab',
        'Ext.form.FieldSet',
        'Ext.form.Label',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Hidden',
        'Ext.XTemplate',
        'Ext.tree.Panel',
        'Ext.tree.View'
    ],

    viewModel: {
        type: 'tabPnLeft'
    },
    border: false,
    id: 'tabPnLeft',
    padding: '',
    style: 'background-color: #DCDCDC;',
    animCollapse: true,
    collapseDirection: 'left',
    headerPosition: 'bottom',
    activeTab: 0,
    plain: true,
    removePanelHeader: false,

    items: [
        {
            xtype: 'panel',
            border: false,
            id: 'tabMenuLifeFond',
            scrollable: true,
            frameHeader: false,
            header: false,
            manageHeight: false,
            title: 'ЖФ',
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            tabConfig: {
                xtype: 'tab',
                frame: false,
                style: 'background-color: #C2D9C9;border:0px;',
                iconCls: 'icon-home',
                closable: false
            },
            items: [
                {
                    xtype: 'fieldset',
                    border: '0px',
                    height: 115,
                    padding: '10 5 10 5',
                    style: 'background-color: #DCDCDC;',
                    title: '',
                    items: [
                        {
                            xtype: 'label',
                            anchor: '100%',
                            height: 22,
                            id: 'showAddress',
                            margin: '5 5 10 5 ',
                            padding: '',
                            style: 'color: #D15706; text-shadow: -1px -1px white, 1px 1px #333;font-size:14pt;text-align:center;',
                            width: 56,
                            text: 'Адрес'
                        },
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            id: 'cbRaion',
                            itemId: 'cbRaion',
                            margin: '10 5 5 5',
                            fieldLabel: '',
                            emptyText: 'Выбрать район',
                            displayField: 'raion',
                            queryMode: 'local',
                            store: 'StRaion',
                            valueField: 'raion_id'
                        },
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            id: 'cbStreet',
                            itemId: 'cbStreet',
                            margin: '10 5 5 5',
                            fieldLabel: '',
                            emptyText: 'Выбрать улицу',
                            displayField: 'street',
                            queryMode: 'local',
                            store: 'StStreet',
                            valueField: 'street_id'
                        },
                        {
                            xtype: 'hiddenfield',
                            id: 'indexTabLifeFond',
                            fieldLabel: 'Label',
                            name: 'indexTabLifeFond',
                            value: 0
                        },
                        {
                            xtype: 'hiddenfield',
                            id: 'indexTabOrg',
                            fieldLabel: 'Label',
                            name: 'indexTabOrg',
                            value: 4
                        }
                    ]
                },
                {
                    xtype: 'panel',
                    flex: 1,
                    id: 'listHouses',
                    style: 'background-color: #DCDCDC;',
                    layout: 'fit',
                    bodyBorder: false,
                    collapseFirst: false,
                    frameHeader: false,
                    header: false,
                    title: '',
                    items: [
                        {
                            xtype: 'dataview',
                            cls: 'feed-list',
                            id: 'listHousesView',
                            scrollable: true,
                            style: 'background-color: #DCDCDC;',
                            tpl: [
                                '<tpl for="."><div class="feed-list-item">{item}</div></tpl>'
                            ],
                            emptyText: '',
                            itemSelector: '.feed-list-item',
                            overItemCls: 'feed-list-item-hover',
                            store: 'StHouses'
                        }
                    ]
                }
            ]
        },
        {
            xtype: 'panel',
            id: 'tabMenuSprav',
            scrollable: true,
            layout: 'fit',
            header: false,
            title: 'Отчеты',
            tabConfig: {
                xtype: 'tab',
                iconCls: 'icon-sprav'
            },
            items: [
                {
                    xtype: 'treepanel',
                    id: 'treeMenuSprav',
                    style: '',
                    title: '',
                    forceFit: true,
                    store: 'StTreeSprav',
                    rootVisible: false,
                    viewConfig: {
                        id: 'treeMenuSpravView',
                        style: 'background-color: #C2D9C9;',
                        loadingText: 'Загрузка...'
                    }
                }
            ]
        }
    ]

});