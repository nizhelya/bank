/*
 * File: app/view/sprav/WinOperator.js
 * Date: Fri May 29 2020 11:48:24 GMT+0300 (EEST)
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

Ext.define('Bank.view.sprav.WinOperator', {
    extend: 'Ext.window.Window',
    alias: 'widget.winoperator',

    requires: [
        'Bank.view.sprav.WinOperatorViewModel',
        'Ext.form.Panel',
        'Ext.button.Button',
        'Ext.form.FieldSet',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Checkbox',
        'Ext.form.field.Hidden'
    ],

    viewModel: {
        type: 'winOperator'
    },
    height: 368,
    id: 'winOperator',
    width: 365,
    layout: 'fit',
    title: 'Ввод нового оператора',
    modal: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'form',
            height: 441,
            id: 'fmOperator',
            layout: 'absolute',
            bodyPadding: 10,
            title: '',
            items: [
                {
                    xtype: 'button',
                    x: 165,
                    y: 265,
                    formBind: true,
                    height: 30,
                    id: 'btAddOperator',
                    width: 160,
                    icon: 'resources/css/images/ico/add.png',
                    text: 'Добавить оператора'
                },
                {
                    xtype: 'button',
                    handler: function(button, event) {
                        button.up('#winOperator').close();
                    },
                    x: 35,
                    y: 265,
                    height: 30,
                    width: 80,
                    icon: 'resources/css/images/ico/delete.png',
                    text: 'Отмена'
                },
                {
                    xtype: 'fieldset',
                    x: 30,
                    y: 25,
                    height: 215,
                    style: 'background-color: #DCDCDC;',
                    width: 290,
                    layout: 'absolute',
                    title: 'Данные по оператору',
                    items: [
                        {
                            xtype: 'combobox',
                            x: 5,
                            y: 15,
                            width: 250,
                            fieldLabel: 'Роль',
                            labelWidth: 90,
                            name: 'role',
                            displayField: 'role',
                            queryMode: 'local',
                            store: 'StRole',
                            valueField: 'role',
                            listeners: {
                                select: 'onComboboxSelect'
                            }
                        },
                        {
                            xtype: 'textfield',
                            x: 5,
                            y: 50,
                            formBind: false,
                            width: 250,
                            fieldLabel: 'Оператор',
                            labelWidth: 90,
                            name: 'login',
                            allowBlank: false,
                            blankText: 'Поле обязательное для заполнения',
                            listeners: {
                                change: 'onTextfieldChange'
                            }
                        },
                        {
                            xtype: 'checkboxfield',
                            handler: function(checkbox, checked) {
                                //console.log(newVal);
                                var form = checkbox.findParentByType('form');
                                var btn = form.down('#btAddOperator');

                                var password = form.getForm().findField('password');

                                if (checked) {
                                    if (password.isHidden()) {
                                        password.show();
                                        btn.setDisabled(true);
                                        password.setValue('');
                                        password.allowBlank=false;


                                    }

                                } else {
                                    if (password.isVisible()){
                                        password.hide();
                                        password.allowBlank = true;
                                        btn.setDisabled(false);

                                    }
                                }

                            },
                            x: 120,
                            y: 80,
                            id: 'chkPassword',
                            fieldLabel: '',
                            name: 'newPasswoed',
                            boxLabel: 'Изменить пароль',
                            inputValue: '1',
                            uncheckedValue: '0'
                        }
                    ]
                },
                {
                    xtype: 'textfield',
                    x: 40,
                    y: 150,
                    id: 'newPassword',
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
                    minLength: 6,
                    minLengthText: 'Не менее 6 символов'
                },
                {
                    xtype: 'hiddenfield',
                    fieldLabel: 'Label',
                    name: 'user_id'
                }
            ]
        }
    ],

    onComboboxSelect: function(combo, record, eOpts) {
        var form = combo.findParentByType('form');
        var btn = form.down('#btAddOperator');

        if (record) {

            btn.setDisabled(false);

        }

    },

    onTextfieldChange: function(field, newValue, oldValue, eOpts) {
        //console.log(newVal);
        var form = field.findParentByType('form');
        var btn = form.down('#btAddOperator');

        if (newValue) {

            btn.setDisabled(false);

        }


    }

});