/*
 * File: app/model/MdHouses.js
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

Ext.define('Bank.model.MdHouses', {
    extend: 'Ext.data.Model',
    alias: 'model.mdHouses',

    requires: [
        'Ext.data.field.Integer',
        'Ext.data.field.String'
    ],

    fields: [
        {
            type: 'int',
            name: 'raion_id'
        },
        {
            type: 'int',
            name: 'street_id'
        },
        {
            type: 'int',
            name: 'house_id'
        },
        {
            type: 'int',
            name: 'address_id'
        },
        {
            type: 'string',
            name: 'house'
        },
        {
            type: 'string',
            name: 'raion'
        },
        {
            type: 'string',
            name: 'street'
        },
        {
            type: 'string',
            name: 'item'
        },
        {
            type: 'string',
            name: 'address'
        },
        {
            type: 'string',
            name: 'appartment'
        }
    ]
});