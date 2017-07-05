$(function(){
    var App = {};

    App._exampleCollection = Backbone.Collection.extend({
        url: '/africa-data'
    });

    App.clearGridCollection = new Backbone.Collection;
    App.exampleCollection = new App._exampleCollection();

    // filters example
    App.eGriFiltersExampld = new bbGrid.View({
        container: $('#bbGrid-filters'),
        rows: 50,
        rowList: [5, 25, 50, 100],
        collection: App.exampleCollection,
        colModel: [
            { title: 'Country of residence', name: 'residence_country', index: true, width: '8%', filter: true },
            { title: 'Sector', index: true, name: 'sector', filter: true, width: '12%'},
            { title: 'Areas of Expertise', index: true, name: 'expertise_areas', filter: true, width: '10%' },
            { title: 'Countries with experience', index: true, name: 'experience_countries', filter: true, filterType: 'input', width: '10%' },
            { title: 'Languages', index: true, name: 'languages', filter: true, filterType: 'input', width: '10%' },
            { title: 'Name', index: true, name: 'name', filter: true, filterType: 'input', width: '10%' },
            { title: 'Notes', index: false, name: 'notes', width: '25%', filter: true, filterType: 'input' },
            { title: 'CV', index: false, name: 'cv', width: '5%' }
        ]
    });

    App.exampleCollection.fetch({ wait: true,
        success:function(collection) {
            App.clearGridCollection.reset(collection.models.slice(0, 10));
        }
    });
});