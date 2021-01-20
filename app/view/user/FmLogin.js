/*
 * File: app/view/user/FmLogin.js
 * Date: Fri May 29 2020 12:01:51 GMT+0300 (EEST)
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

Ext.define('Bank.view.user.FmLogin', {
    extend: 'Ext.form.Panel',
    alias: 'widget.fmlogin',

    requires: [
        'Bank.view.user.FmLoginViewModel',
        'Ext.form.FieldSet',
        'Ext.form.field.ComboBox',
        'Ext.button.Button',
        'Ext.form.field.Checkbox',
        'Ext.form.field.Number',
        'Ext.form.Label'
    ],

    viewModel: {
        type: 'fmLogin'
    },
    height: 285,
    id: 'fmLogin',
    width: 599,
    layout: 'fit',
    paramsAsHash: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'fieldset',
            html: '<IMG SRC="resources/css/images/bank.png" >',
            style: 'background-color: #DCDCDC;',
            layout: 'absolute',
            title: '',
            items: [
                {
                    xtype: 'combobox',
                    x: 255,
                    y: 65,
                    width: 280,
                    fieldLabel: 'Оператор банка',
                    labelWidth: 120,
                    name: 'user_id',
                    allowBlank: false,
                    displayField: 'login',
                    forceSelection: true,
                    queryMode: 'local',
                    store: 'StCbOperatorBank',
                    typeAhead: true,
                    valueField: 'user_id',
                    listeners: {
                        select: 'onComboboxSelect1'
                    }
                },
                {
                    xtype: 'combobox',
                    x: 255,
                    y: 20,
                    width: 280,
                    fieldLabel: 'Отделение банка',
                    labelWidth: 120,
                    name: 'otdel_id',
                    allowBlank: false,
                    displayField: 'otdel',
                    forceSelection: true,
                    queryMode: 'local',
                    store: 'StCbOtdelenieBank',
                    typeAhead: true,
                    valueField: 'otdel_id',
                    listeners: {
                        select: 'onComboboxSelect'
                    }
                },
                {
                    xtype: 'button',
                    x: 260,
                    y: 185,
                    hidden: true,
                    id: 'info_remember',
                    icon: 'resources/css/images/ico/information.png',
                    text: '',
                    tooltip: 'Галочка в поле <Запомнить> - сохранит Ваш Логин и пароль на компьтере, что позволит Вам не заполнять поля  при следующей авторизации.'
                },
                {
                    xtype: 'checkboxfield',
                    x: 290,
                    y: 185,
                    hidden: true,
                    fieldLabel: '',
                    name: 'remember',
                    boxLabel: 'запомнить',
                    inputValue: '1'
                },
                {
                    xtype: 'numberfield',
                    x: 145,
                    y: 125,
                    hidden: true,
                    width: 50,
                    fieldLabel: '',
                    name: 'attempt',
                    value: 0,
                    hideTrigger: true,
                    decimalPrecision: 0
                },
                {
                    xtype: 'button',
                    x: 410,
                    y: 180,
                    formBind: true,
                    cls: 'button',
                    disabled: true,
                    height: 30,
                    id: 'btninput',
                    width: 100,
                    allowDepress: false,
                    iconCls: 'icon-door-in',
                    text: 'Вход'
                },
                {
                    xtype: 'textfield',
                    x: 280,
                    y: 110,
                    id: 'password',
                    itemId: 'password',
                    width: 255,
                    fieldLabel: 'Пароль',
                    labelPad: 2,
                    msgTarget: 'under',
                    name: 'password',
                    inputType: 'password',
                    allowBlank: false,
                    blankText: 'Пароль не введен',
                    maxLength: 32,
                    maxLengthText: 'Не более 32 символов',
                    minLength: 3,
                    minLengthText: 'Не менее 3 символов'
                },
                {
                    xtype: 'label',
                    x: 245,
                    y: 235,
                    hidden: true,
                    id: 'chekLogin',
                    style: '{color: #D15706; text-shadow: -1px -1px white, 1px 1px #333;font-size:11pt;text-align:center;}',
                    width: 300,
                    text: 'Неверный логин или пароль. Попытка №'
                }
            ]
        }
    ],

    onComboboxSelect1: function(combo, record, eOpts) {
        var form = combo.findParentByType('form');
        form.getForm().findField('remember').show();
        form.down('#info_remember').show();

    },

    onComboboxSelect: function(combo, record, eOpts) {
        var form = combo.findParentByType('form');
        form.getForm().findField('remember').show();
        form.down('#info_remember').show();

    }

});