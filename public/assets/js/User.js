let compareList = [];

function addToCompare(propertyId) {

    if (compareList.includes(propertyId)) {
        alert("This property is already selected.");
        return;
    }

    compareList.push(propertyId);

    if (compareList.length === 2) {
        let ids = compareList.join(",");
        window.location.href = "/compare-properties?ids=" + ids;
    } else {
        alert("Property added. Select one more to compare.");
    }
}
