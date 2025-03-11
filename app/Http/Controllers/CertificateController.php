<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Показывает список сертификатов пользователя
     */
    public function index()
    {
        $certificates = Auth::user()->certificates;

        return view('student.certificates.index', [
            'certificates' => $certificates
        ]);
    }

    /**
     * Скачивание сертификата
     */
    public function download(Certificate $certificate)
    {
        // Проверка, что сертификат принадлежит текущему пользователю
        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        // Готовим файл сертификата для скачивания (заглушка)
        // TODO: Реализовать генерацию PDF-файла сертификата

        return redirect()->back()->with('status', 'Функция скачивания сертификатов находится в разработке.');
    }
}
