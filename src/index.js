/**
 * External dependencies
 */
import React, { useState, useEffect } from 'react';
import { render } from 'react-dom';

/**
 * Internal dependencies
 */
import './index.scss';
import { SearchForm } from './search/searchForm';
import { SearchResults } from './search/searchResults';
import { FileDisplay } from './search/fileDisplay';

const RootComponent = () => {
	const [results, setResults] = useState([]);
	const [fileContent, setFileContent] = useState('');
	const [isSearching, setIsSearching] = useState(false);
	const [file, setFile] = useState('');

	useEffect(() => {}, [file]);

	return (
		<>
			<SearchForm
				setResults={setResults}
				isSearching={isSearching}
				setIsSearching={setIsSearching}
			/>
			{results && (
				<SearchResults
					results={results}
					setIsSearching={setIsSearching}
					setFileContent={setFileContent}
					setFile={setFile}
				/>
			)}
			{fileContent && (
				<FileDisplay fileContent={fileContent} file={file} />
			)}
		</>
	);
};
const domContainer = document.querySelector('#log-search');
render(<RootComponent />, domContainer);
