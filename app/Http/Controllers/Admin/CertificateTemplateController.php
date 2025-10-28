<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateTemplateController extends Controller
{
  public function index()
  {
    // Mengambil data template dengan paginasi, 10 item per halaman, diurutkan dari yang terbaru
    $templates = CertificateTemplate::latest()->paginate(10);

    // Variabel $events tidak digunakan di view index, jadi bisa dihapus jika tidak diperlukan
    // $events = Event::all(); 

    return view('admin.certificate-template.index', compact('templates'));
  }

  public function create()
  {
    return view('admin.certificate-template.create');
  }

  public function store(Request $request)
  {
    // Validasi dan simpan data baru
    $this->updateTemplateData($request, new CertificateTemplate());
    return redirect()->route('admin.certificate-templates.index')->with('success', 'New template has been successfully created.');
  }

  // Menampilkan form edit
  public function edit(CertificateTemplate $certificateTemplate)
  {
    return view('admin.certificate-template.edit', ['template' => $certificateTemplate]);
  }

  public function update(Request $request, CertificateTemplate $certificateTemplate)
  {
    // Validasi dan update data yang ada
    $this->updateTemplateData($request, $certificateTemplate);
    return redirect()->route('admin.certificate-templates.index')->with('success', 'Template has been successfully updated.');
  }

  public function destroy(CertificateTemplate $certificateTemplate)
  {
    // Hapus semua gambar terkait
    $imageFields = ['background_image', 'logo1', 'logo2', 'logo3', 'logo4', 'logo5', 'logo6', 'logo7', 'center_logo', 'signature1_image', 'signature2_image', 'signature3_image'];
    foreach ($imageFields as $field) {
      if ($certificateTemplate->{$field}) {
        Storage::disk('public')->delete($certificateTemplate->{$field});
      }
    }
    $certificateTemplate->delete();
    return redirect()->route('admin.certificate-templates.index')->with('success', 'Template has been successfully deleted.');
  }

  // Menyimpan perubahan
  public function updateTemplateData(Request $request, CertificateTemplate $template)
  {
    // $template = CertificateTemplate::firstOrCreate([]);
    $validated = $request->validate([
      // Validasi untuk text input
      'template_name' => 'required|string|max:255',
      'main_title' => 'nullable|string|max:255',
      'signature1_name' => 'nullable|string|max:255',
      'signature1_title' => 'nullable|string|max:255',
      'signature2_name' => 'nullable|string|max:255',
      'signature2_title' => 'nullable|string|max:255',
      'signature3_name' => 'nullable|string|max:255',
      'signature3_title' => 'nullable|string|max:255',
      // Validasi untuk semua file gambar (opsional)
      'background_image' => 'nullable|image|max:2048',
      // 'logo*' => 'nullable|image|max:1024',
      'logo1' => 'nullable|image|max:1024',
      'logo2' => 'nullable|image|max:1024',
      'logo3' => 'nullable|image|max:1024',
      'logo4' => 'nullable|image|max:1024',
      'logo5' => 'nullable|image|max:1024',
      'logo6' => 'nullable|image|max:1024',
      'logo7' => 'nullable|image|max:1024',
      'center_logo' => 'nullable|image|max:1024',
      'signature1_image' => 'nullable|image|max:1024',
      'signature2_image' => 'nullable|image|max:1024',
      'signature3_image' => 'nullable|image|max:1024',
      'body_text' => 'nullable|string',
      'winner_text' => 'nullable|string',
      'supporting_text' => 'nullable|string',
      'participant_text' => 'nullable|string',
    ]);

    // Daftar semua field gambar untuk di-loop
    $dataToUpdate = $validated;
    $imageFields = ['background_image', 'logo1', 'logo2', 'logo3', 'logo4', 'logo5', 'logo6', 'logo7', 'center_logo', 'signature1_image', 'signature2_image', 'signature3_image'];

    foreach ($imageFields as $field) {
      if ($request->hasFile($field)) {
        if ($template->{$field}) {
          Storage::disk('public')->delete($template->{$field});
        }
        $dataToUpdate[$field] = $request->file($field)->store('certificate_assets', 'public');
      }
    }

    $textFields = ['signature1_name', 'signature1_title', 'signature2_name', 'signature2_title', 'signature3_name', 'signature3_title'];
    foreach ($textFields as $field) {
      $dataToUpdate[$field] = $request->input($field);
    }

    $template->fill($dataToUpdate)->save();
    // return redirect()->route('admin.certificate-template.edit')->with('success', 'Template sertifikat berhasil diperbarui.');
  }
  public function preview(CertificateTemplate $certificateTemplate)
  {
    // buat dummy event
    $dummyEvent = new Event([
      'title' => 'Event Name (Example)',
      'start_date' => now(),
    ]);

    // attach template ke event (relasi belongsTo)
    $dummyEvent->setRelation('certificateTemplate', $certificateTemplate);

    $dummyParticipant = new Participant([
      'name' => 'Participant Name (Example)',
      'group' => 'Group / Institution (Example)',
      'category' => 'Winner (Example)',
      'subcategory' => 'Sub-Categoty (Example)',
      'type' => 'Dance Categoty (Example)',
      'certificate_number' => 'COI-DUMMY-DOWNLOAD'
    ]);

    // attach event ke participant
    $dummyParticipant->setRelation('event', $dummyEvent);

    return view('pages.certificate-preview', [
      'participant' => $dummyParticipant,
      'is_preview' => true
    ]);


  }

  public function download(CertificateTemplate $template)
  {
    $dummyEvent = new Event([
      'title' => 'Event Name (Example)',
      'start_date' => now(),
    ]);
    $dummyEvent->setRelation('certificateTemplate', $template);

    $dummyParticipant = new Participant([
      'name' => 'Participant Name (Example)',
      'group' => 'Group / Institution (Example)',
      'category' => 'Winner (Example)',
      'subcategory' => 'Sub-Categoty (Example)',
      'type' => 'Dance Categoty (Example)',
      'certificate_number' => 'COI-DUMMY-DOWNLOAD'
    ]);
    $dummyParticipant->setRelation('event', $dummyEvent);

    $pdf = Pdf::loadView('certificate.template', [
      'participant' => $dummyParticipant,
      'is_preview' => false
    ])->setPaper('a4', 'landscape');

    $fileName = 'preview-' . \Illuminate\Support\Str::slug($template->template_name) . '.pdf';

    return $pdf->download($fileName);
  }



}