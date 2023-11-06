import dayjs from 'dayjs';
import 'dayjs/locale/fr';

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

export const capitalized = (word) =>{
    return word.charAt(0).toUpperCase() + word.slice(1);
}

export const moment = (date) => {
    return dayjs(date).locale('fr');
}

export const parseDate = (input,format) => {
    format = format || 'yyyy-mm-dd';
    let parts = input.match(/(\d+)/g), i = 0,fmt ={};
    format.replace(/(yyyy|dd|mm)/g, (parts) => {fmt[parts] = i++;})
    return new Date(parts[fmt['yyyy']],parts[fmt['mm']]-1,parts[fmt['dd']]);
}

export const getCurrentRoute = () => {
    let routeName = route().current();
    if (routeName.indexOf(".") === -1) return routeName;
    return routeName.substring(0, routeName.indexOf("."))
}
