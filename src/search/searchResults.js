/**
 * Internal dependencies
 */
import { getFile } from '../utilities/DataStore';
import { RenderResult } from './renderResult';

export const SearchResults = (props) => {
	const results = props.results;

	const handleClick = (result) => {
		props.setIsSearching(true);
		getFile({ file: result })
			.then((resp) => props.setFileContent(resp))
			.then(
				setTimeout(() => {
					props.setIsSearching(false);
				}, '200')
			);
	};

	return (
		<ol>
			{results.map((result, index) => (
				<RenderResult
					key={index}
					result={result}
					handleClick={handleClick}
				/>
			))}
		</ol>
	);
};
