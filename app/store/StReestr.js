/*
 * File: app/store/StReestr.js
 * Date: Thu May 28 2015 20:54:58 GMT+0300 (EEST)
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

Ext.define('Bank.store.StReestr', {
    extend: 'Ext.data.Store',
    alias: 'store.stReestr',

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
            storeId: 'stReestr',
            model: 'Bank.model.MdBank',
            proxy: {
                type: 'direct',
                api: {
                    create: 'QuerySprav.createRecord',
                    read: 'QuerySprav.getResults',
                    update: 'QuerySprav.updateRecords',
                    destroy: 'QuerySprav.destroyRecord'
                },
                extraParams: {
                    what: 'getReestr'
                },
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});