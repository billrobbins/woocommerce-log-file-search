export const RenderResult = (props) => {
	const result = props.result;

	if (result.file.length) {
		return (
			<li>
				<button onClick={() => props.handleClick(result.file)}>
					{result.file}
				</button>
				{result.snippets.map((snippet, count) => (
					<pre key={count} className="snippet">
						{snippet}
					</pre>
				))}
			</li>
		);
	}
	return <p>No files found</p>;
};
