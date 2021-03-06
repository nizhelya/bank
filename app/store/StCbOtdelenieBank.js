/*
 * File: app/store/StCbOtdelenieBank.js
 * Date: Wed May 27 2015 14:23:59 GMT+0300 (EEST)
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

Ext.define('Bank.store.StCbOtdelenieBank', {
    extend: 'Ext.data.Store',
    alias: 'store.stCbOtdelenieBank',

    requires: [
        'Bank.model.MdBank',
        'Ext.data.proxy.Direct',
        'Bank.DirectAPI',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'stCbOtdelenieBank',
            model: 'Bank.model.MdBank',
            proxy: {
                type: 'direct',
                extraParams: {
                    what: 'OtdelenieBanka'
                },
                directFn: 'QueryLoad.getResults',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});