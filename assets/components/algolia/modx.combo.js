MODx.combo.ResourceType = function(config) {
    config = config || {};

    let data = [
        ['modDocument','modDocument'],
        ['msProduct','msProduct'],
        ['pbResource','pbResource'],
    ];

    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 'value',
            fields: ['name','value'],
            data: data
        }),
        mode: 'local',
        displayField: 'name',
        valueField: 'value',
    });
    MODx.combo.ResourceType.superclass.constructor.call(this,config);
};
Ext.extend(MODx.combo.ResourceType,MODx.combo.ComboBox);
Ext.reg('algolia-combo-resource-type',MODx.combo.ResourceType);