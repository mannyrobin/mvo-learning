<?php 

namespace WPFGS;

class ProviderHelper 
{
	public function getColumnFromIndex( $index )
	{
		$numeric = $index % 26;
		$letter = chr(65 + $numeric);
		$next = intval( $index / 26 );
		
		if ( $next > 0 ) {
			return $this->getColumnFromIndex( $next - 1 ) . $letter;
		} else {
			return $letter;
		}
	}
	
	public function mapRowToHeadings( $row )
	{
		if ( empty( $row ) )
			throw new \Exception( "The first row of sheet should be a set of column headers" );
		
		$headings = [];
		
		foreach ( $row as $index => $value ) {
			$column = $this->getColumnFromIndex( $index );
			$headings[$column] = [
				'id'			=> $column,
				'tag'			=> $column,
				'name'		=> $value,
				'req'			=> false,
				'field_type'	=> 'text'
			];
		}
		
		return $headings;
	}
	
	public static function splitId( $str )
	{
		return explode( '--', $str );
	}
}
