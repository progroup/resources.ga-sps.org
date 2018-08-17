$(document).ready(function(){
    $('.resources-table').DataTable({
            paging: false,
            ordering: true,
            info: false,
            searching: false,
            stateSave: false,
            order: [[ 2, "desc" ]],
            language: {
                search: 'Filter: ',
                emptyTable: 'There are no resources matching your search criteria.' 
            }
    });
});
