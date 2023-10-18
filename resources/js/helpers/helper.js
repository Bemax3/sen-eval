export const isEmpty = (obj) => {
    return Object.keys(obj).length === 0;
}

export const hasData = (array) => {
    return array.length > 0
}

export const getPagination = (obj) => {
    return {
        links: obj.links,
        per_page: obj.per_page,
        total: obj.total,
        from: obj.from,
        to: obj.to,
    };
}
