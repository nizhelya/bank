/*
 * File: app/view/VpKommuna.js
 * Date: Fri May 29 2020 12:19:49 GMT+0300 (EEST)
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

Ext.define('Bank.view.VpKommuna', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.vpkommuna',

    requires: [
        'Bank.view.VpKommunaViewModel',
        'Bank.view.menu.TabPnCenter',
        'Bank.view.menu.TabPnLeft',
        'Ext.tab.Panel'
    ],

    viewModel: {
        type: 'vpKommuna'
    },
    layout: 'border',

    items: [
        {
            xtype: 'tabpncenter',
            height: 714,
            flex: 1,
            region: 'center',
            split: true
        },
        {
            xtype: 'panel',
            region: 'south',
            height: 21,
            html: '<center><span style="color:#04468C;text-shadow: 2px 3px 5px #bfbfbf;position:absolute;\ndisplay:block;top:3px;letter-spacing:-.05em;font-family:serif;left:0;height:60%;width:100%;\nbackground-color:#FFFFFF;filter:alpha(opacity=65);\n-moz-opacity: 0.65;opacity: 0.65;">&copy;2004 -2012 <span>Южненская Коммунальная Информационная Система\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ITX&nbsp;&amp;&nbsp;Нижельский С.А.</span></center>',
            style: 'background-color: #DCDCDC;',
            title: ''
        },
        {
            xtype: 'panel',
            region: 'west',
            maxWidth: 220,
            width: 220,
            title: '',
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'container',
                    border: false,
                    height: 96,
                    html: '<h6 class="header"><span>Южненская Коммунальная<br>Информационная Система</span></h6>',
                    padding: 10,
                    style: 'background-color: #DCDCDC;',
                    width: 217,
                    layout: {
                        type: 'vbox',
                        align: 'stretch'
                    }
                },
                {
                    xtype: 'tabpnleft',
                    width: 240,
                    flex: 3
                }
            ]
        }
    ]

});