<?php


class ProviderHelperTest extends \Codeception\Test\Unit
{
	/**
		* @var \UnitTester
		*/
	protected $tester;

	protected function _before()
	{
		$this->helper = new \WPFGS\ProviderHelper();
	}

	protected function _after()
	{
	}

	public function testMappingRowToHeadings()
	{
		$input = [ 'Name', 'Rank', 'Serial #', 'Favorite Sexual Position' ];
		$expect = [
			'A' => [
				'id'					=> 'A',
				'tag'					=> 'A',
				'name'				=> 'Name',
				'req'					=> false,
				'field_type'	=> ''
			],
			'B'	=> [
				'id'					=> 'B',
				'tag'					=> 'B',
				'name'				=> 'Rank',
				'req'					=> false,
				'field_type'	=> ''
			],
			'C'	=> [
				'id'					=> 'C',
				'tag'					=> 'C',
				'name'				=> 'Serial #',
				'req'					=> false,
				'field_type'	=> ''
			],
			'D'	=> [
				'id'					=> 'D',
				'tag'					=> 'D',
				'name'				=> 'Favorite Sexual Position',
				'req'					=> false,
				'field_type'	=> ''
			]
		];
		
		$this->assertEquals( $expect, $this->helper->mapRowToHeadings( $input ) );
	}
	
	public function testExceptionMappingEmptyRowToHeadings()
	{
		$this->expectException( \Exception::class );
		$this->helper->mapRowToHeadings([]);
	}
    
	public function testGetColumnFromIndex()
	{
		$input = 4;
		$expect = 'E';
		
		$this->assertEquals( $expect, $this->helper->getColumnFromIndex( $input ) );
	}
	
	public function testGetTwoLetterColumnFromIndex()
	{
		$input = 28;
		$expect = 'AC';
		
		$this->assertEquals( $expect, $this->helper->getColumnFromIndex( $input ) );
	}
	
	public function testSplitId()
	{
		$id = "3lkfdjo3lkjfw-4wjflisef-3sjeoidl";
		$sheet = "Sheet 1";
		$combined = "3lkfdjo3lkjfw-4wjflisef-3sjeoidl--Sheet 1";
		
		$split = \WPFGS\ProviderHelper::splitId($combined);
		
		$this->assertEquals( $id, $split[0] );
		$this->assertEquals( $sheet, $split[1] );
	}
}
