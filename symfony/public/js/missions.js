var $table = $('#missionstable')
var selections = []

// Add more params for the filters
function queryParams(params) {
    params.status = $('#statusFilter').val();
    params.country = $('#countryFilter').val();
    params.type = $('#typeFilter').val();
    return params;
}

$('#statusFilter, #countryFilter, #typeFilter').change(function () {
    $table.bootstrapTable('refresh')
})

// To display the status badge
const displayMissionStatus = (status) => {
    let formattedStatus = '';

    switch (status) {
        case 'inpreparation' :
            formattedStatus = '<span class="badge badge-secondary">In preparation</span>';
            break;
        case 'inprogress' :
            formattedStatus = '<span class="badge badge-warning">In progress</span>';
            break;
        case 'completed' :
            formattedStatus = '<span class="badge badge-success">Completed</span>';
            break;
        case 'failed' :
            formattedStatus = '<span class="badge badge-danger">Failed</span>';
            break;
    }

    return formattedStatus;
}

// To display the flag country
const displayMissionCountry = (iso) => {
    let formattedCountry;
    formattedCountry = '<img src="images/country/'+iso.toLowerCase()+'.png" />';
    return formattedCountry;
}

function responseHandler(res) {
    $.each(res.rows, (i, row) => {
        row.state = $.inArray(row.id, selections) !== -1
    })
    return res
}

function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
        locale: 'en-US',
        columns: [
            [
                {
                    field: 'code',
                    title: 'Code',
                    sortable: true,
                    align: 'center'
                },{
                field: 'status',
                title: 'Status',
                sortable: true,
                align: 'center',
                formatter: displayMissionStatus
            },{
                field: 'title',
                title: 'Title',
                sortable: true,
                align: 'center'
            },{
                field: 'country',
                title: 'Country',
                sortable: true,
                align: 'center',
                formatter: displayMissionCountry
            },{
                field: 'type',
                title: 'Type',
                sortable: true,
                align: 'center'
            },{
                field: 'start',
                title: 'Start',
                sortable: true,
                align: 'center'
            },{
                field: 'end',
                title: 'End',
                sortable: true,
                align: 'center'
            }
            ]
        ]
    })

    // Event to load the modal details
    $table.on('click-cell.bs.table', (field, value, row, $el) => {
        $.getJSON( '/mission/details/'+$el.idmission, (data) => {
            $('#detailsMissionModalLabel').text(data.title);
            let missionContent = '';

            // Missions infos
            missionContent += `
                    <div class="row">
                        <div class="col-sm-12 pb-3">
                            ${data.description}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">Status</label>
                        <div class="col-sm-10">
                            ${displayMissionStatus(data.status)}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">Code</label>
                        <div class="col-sm-10">
                            ${data.code}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">Country</label>
                        <div class="col-sm-10">
                            ${displayMissionCountry(data.country)}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">Type</label>
                        <div class="col-sm-10">
                            ${data.type}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">Speciality</label>
                        <div class="col-sm-10">
                            ${data.speciality}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">Start</label>
                        <div class="col-sm-10">
                            ${data.start}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2">End</label>
                        <div class="col-sm-10">
                            ${data.end}
                        </div>
                    </div>
                `;

            // Mission's Hideouts
            missionContent += (data.hideout !== undefined && Object.keys(data.hideout).length) ?
                '<h5 class="mt-4"><i class="fa fa-map-marker"></i> Hideouts</h5>' : '';
            $.each(data.hideout, function(key, location) {
                missionContent += `
                        <div class="row border-top">
                            <label class="col-sm-3">${location.code} - ${location.type}</label>
                            <div class="col-sm-9">
                                ${location.address} - ${location.postcode} ${location.city} ${displayMissionCountry(location.country)}
                            </div>
                        </div>
                    `;
            });

            // Mission's agents
            missionContent += (data.user !== undefined && Object.keys(data.user).length) ?
                '<h5 class="mt-4"><i class="fa fa-user-secret"></i> Person entities</h5>' : '';

            $.each(data.user, function(key, user) {
                let userSpec = '';
                if(user.type === 'agent' && Object.keys(user.speciality).length) {
                    userSpec = '<br /><small>'+Object.values(user.speciality).join(' / ')+'</small>';
                }

                missionContent += `
                    <div class="row border-top">
                        <label class="col-sm-3">${user.type[0].toUpperCase() + user.type.substring(1)} - ${user.code}</label>
                        <div class="col-sm-9">
                            ${user.name} ${user.firstname} - ${user.nationality} (${user.born})${userSpec}
                        </div>
                    </div>
                    `;
            });

            $('#detailsMissionModal .modal-body').html('<div class="container-fluid">'+missionContent+'</div>');
            $('#detailsMissionModal').modal('toggle')
        });
    });
}

$(function() {
    initTable();
})