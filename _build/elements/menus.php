<?php

return [
    'algolia' => [
        'description' => 'algolia.update_index',
        'action' => '',
        'handler' => "MODx.msg.confirm({
            title: _('algolia.update_index')
            ,text: _('algolia.update_index_confirm')
            ,url: Algolia.config.connectorUrl
            ,params: {
                action: 'index/update'
            }
            ,listeners: {
                'success': {fn:function(r) { 
                    console.log(r); 
                    Ext.MessageBox.alert('Success', 'Added: ' + r.total); 
                },scope:this},
                'failure': {fn:function(response) { Ext.MessageBox.alert('failure', response.responseText); },scope:this},
            }
        });"
    ],
    'algolia.clear_index' => [
        'parent' => 'algolia',
        'description' => 'algolia.clear_index_description',
        'action' => '',
        'handler' => "MODx.msg.confirm({
            title: _('algolia.clear_index')
            ,text: _('algolia.clear_index_confirm')
            ,url: Algolia.config.connectorUrl
            ,params: {
                action: 'index/clear'
            }
            ,listeners: {
                'success': {fn:function(r) { 
                    console.log(r); 
                    Ext.MessageBox.alert(r.success ? 'Success' : 'Error', r.message); 
                },scope:this},
                'failure': {fn:function(response) { Ext.MessageBox.alert('failure', response.responseText); },scope:this},
            }
        });"
    ]

];