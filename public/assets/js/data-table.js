document.addEventListener('DOMContentLoaded', function () {

    function initTable(tableId) {
        const tableEl = document.getElementById(tableId);
        if (!tableEl) return null;

        const table = new simpleDatatables.DataTable(`#${tableId}`, {
            perPageSelect: false,
            columns: [
                { select: [0, 6], sortable: false }
            ],
            rowRender: (row, tr, _index) => {
                if (!tr.attributes) {
                    tr.attributes = {};
                }
                if (!tr.attributes.class) {
                    tr.attributes.class = "";
                }
                if (row.selected) {
                    tr.attributes.class += " selected";
                } else {
                    tr.attributes.class = tr.attributes.class.replace(" selected", "");
                }
                return tr;
            }
        });

        return table;
    }

    const selectionTable1 = initTable("selection-table-1");
    const selectionTable2 = initTable("selection-table-2");
    const popupTable = initTable("popup-table");
});
