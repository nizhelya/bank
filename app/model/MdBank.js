/*
 * File: app/model/MdBank.js
 * Date: Thu Dec 03 2020 20:46:26 GMT+0200 (EET)
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

Ext.define('Bank.model.MdBank', {
    extend: 'Ext.data.Model',
    alias: 'model.mdBank',

    requires: [
        'Ext.data.field.String',
        'Ext.data.field.Date',
        'Ext.data.field.Number'
    ],

    fields: [
        {
            type: 'int',
            name: 'nom'
        },
        {
            type: 'string',
            name: 'nomer'
        },
        {
            type: 'date',
            name: 'data'
        },
        {
            type: 'int',
            name: 'address_id'
        },
        {
            type: 'string',
            name: 'address'
        },
        {
            type: 'int',
            name: 'inn'
        },
        {
            type: 'string',
            name: 'client'
        },
        {
            type: 'string',
            name: 'bank'
        },
        {
            name: 'account'
        },
        {
            type: 'int',
            name: 'okpo'
        },
        {
            type: 'int',
            name: 'mfo'
        },
        {
            type: 'float',
            name: 'summa'
        },
        {
            type: 'string',
            name: 'detali'
        },
        {
            type: 'string',
            name: 'otdel'
        },
        {
            type: 'int',
            name: 'oaccount'
        },
        {
            type: 'int',
            name: 'taccount'
        },
        {
            type: 'string',
            name: 'pr'
        },
        {
            type: 'int',
            name: 'otdel_id'
        },
        {
            type: 'int',
            name: 'userl_id'
        },
        {
            type: 'int',
            name: 'kod'
        },
        {
            type: 'int',
            name: 'out'
        },
        {
            type: 'string',
            name: 'operator'
        },
        {
            type: 'string',
            name: 'data_in'
        },
        {
            type: 'string',
            name: 'usluga'
        },
        {
            type: 'int',
            name: 'role'
        },
        {
            type: 'int',
            name: 'timeout'
        },
        {
            type: 'string',
            name: 'fio'
        }
    ]
});