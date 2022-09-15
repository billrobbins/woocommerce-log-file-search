/**
 * External dependencies
 */
import React, { useState, useEffect } from 'react';

/**
 * Internal dependencies
 */
import { Loader } from '../utilities/loader';
import { searchSend } from '../utilities/DataStore';

export const SearchForm = (props) => {
	const [searchTerm, setSearchTerm] = useState({
		search: '',
	});

	useEffect(() => {}, [props.isSearching]);

	const handleChange = (event) => {
		setSearchTerm({
			[event.target.name]: event.target.value,
		});
	};

	const handleSubmit = async (event) => {
		event.preventDefault();
		props.setIsSearching(true);
		try {
			const searchResults = await searchSend(searchTerm);
			props.setResults(searchResults);
		} catch (error) {
			console.error(error);
		} finally {
			props.setIsSearching(false);
		}
	};

	return (
		<form className="form-log-search" onSubmit={handleSubmit}>
			<input
				type="text"
				name="search"
				placeholder="Enter Search Term"
				className="regular-text"
				value={searchTerm.search}
				onChange={handleChange}
			/>
			{props.isSearching && <Loader />}
			<input
				type="submit"
				value="Search"
				className="button button-primary"
			/>
		</form>
	);
};
