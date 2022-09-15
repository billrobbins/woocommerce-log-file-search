/**
 * External dependencies
 */
import apiFetch from '@wordpress/api-fetch';

const searchSend = (data) => {
	return apiFetch({
		path: '/wc-log-search/v1/search',
		method: 'POST',
		data,
	});
};

const getFile = (data) => {
	return apiFetch({
		path: '/wc-log-search/v1/get_file',
		method: 'POST',
		data,
	});
};

export { searchSend, getFile };
