<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
		\Myth\Auth\Authentication\Passwords\ValidationRules::class
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $kategori = [
		'nama' => [
			'label' => 'Nama Kategori',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		]
	];

	public $satuan = [
		'nama' => [
			'label' => 'Nama Satuan',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		]
	];

	public $produk = [
		'barcode' => [
			'label' => 'Kode Barcode',
			'rules' => 'required|is_unique[produk.barcode]|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'is_unique[produk.barcode]' => '{field} sudah ada!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'nama' => [
			'label' => 'Nama Produk',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'harga_beli' => [
			'label' => 'Harga Beli',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'harga_jual' => [
			'label' => 'Harga Jual',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'stok' => [
			'label' => 'Stok Produk',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		]
	];

	public $produkEdit = [
		'barcode' => [
			'label' => 'Kode Barcode',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'is_unique[produk.barcode]' => '{field} sudah ada!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'nama' => [
			'label' => 'Nama Produk',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'harga_beli' => [
			'label' => 'Harga Beli',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'harga_jual' => [
			'label' => 'Harga Jual',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'stok' => [
			'label' => 'Stok Produk',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		]
	];

	public $member = [
		'nama' => [
			'label' => 'Nama Lengkap',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'email' => [
			'label' => 'E-mail',
			'rules' => 'valid_email|is_unique[member.email]',
			'errors' => [
				'valid_email' => 'Format {field} tidak valid!',
				'is_unique[member.email]' => '{field} sudah digunakan.'
			]
		],
		'telp' => [
			'label' => 'Nomor Telepon',
			'rules' => 'required|is_unique[member.telepon]|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'is_unique[member.telepon]' => '{field} sudah ada.',
				'numeric' => '{field} harus berupa angka.'
			]
		],
		'alamat' => [
			'label' => 'Alamat',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		]
	];

	public $memberEditEmail = [
		'nama' => [
			'label' => 'Nama Lengkap',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'email' => [
			'label' => 'E-mail',
			'rules' => 'valid_email|is_unique[member.email]',
			'errors' => [
				'valid_email' => 'Format {field} tidak valid!',
				'is_unique[member.email]' => '{field} sudah digunakan.'
			]
		],
		'telp' => [
			'label' => 'Nomor Telepon',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka.'
			]
		],
		'alamat' => [
			'label' => 'Alamat',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		]
	];

	public $memberEditTelp = [
		'nama' => [
			'label' => 'Nama Lengkap',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'email' => [
			'label' => 'E-mail',
			'rules' => 'valid_email',
			'errors' => [
				'valid_email' => 'Format {field} tidak valid!'
			]
		],
		'telp' => [
			'label' => 'Nomor Telepon',
			'rules' => 'required|is_unique[member.telepon]|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'is_unique[member.telepon]' => '{field} sudah ada.',
				'numeric' => '{field} harus berupa angka.'
			]
		],
		'alamat' => [
			'label' => 'Alamat',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		]
	];

	public $supplier = [
		'nama' => [
			'label' => 'Nama Supplier',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'telp' => [
			'label' => 'Nomor Telepon',
			'rules' => 'required|is_unique[supplier.telepon]|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'is_unique[supplier.telepon]' => '{field} sudah ada.',
				'numeric' => '{field} harus berupa angka.'
			]
		]
	];

	public $supplierEdit = [
		'nama' => [
			'label' => 'Nama Supplier',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'telp' => [
			'label' => 'Nomor Telepon',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka.'
			]
		]
	];

	public $stockIn = [
		'barcode' => [
			'label' => 'Barcode',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		],
		'detail' => [
			'label' => 'Detail',
			'rules' => 'required',
			'errors' => [
				'required' => '{field} harus diisi!'
			]
		],
		'qty' => [
			'label' => 'Quantity',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => '{field} harus diisi!',
				'numeric' => '{field} harus berupa angka!'
			]
		]
	];
}
