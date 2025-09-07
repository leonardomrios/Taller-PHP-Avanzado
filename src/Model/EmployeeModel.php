<?php
namespace App\Model;

class EmployeeModel
{
    /** @var array<int, array{name:string,salary:float,department:string}> */
    private array $employees;

    public function __construct(array $employees)
    {
        // normaliza tipos
        $this->employees = array_map(function ($e) {
            return [
                'name' => (string)($e['name'] ?? ''),
                'salary' => (float)($e['salary'] ?? 0),
                'department' => (string)($e['department'] ?? '')
            ];
        }, $employees);
    }

    /** @return array<string,float> */
    public function averageSalaryByDepartment(): array
    {
        $sum = $count = [];
        foreach ($this->employees as $e) {
            $d = $e['department'];
            $sum[$d] = ($sum[$d] ?? 0) + $e['salary'];
            $count[$d] = ($count[$d] ?? 0) + 1;
        }
        $avg = [];
        foreach ($sum as $d => $s) {
            $avg[$d] = $count[$d] ? round($s / $count[$d], 2) : 0.0;
        }
        ksort($avg);
        return $avg;
    }

    /** @return array{department:string,average:float}|null */
    public function departmentWithHighestAverage(): ?array
    {
        $avg = $this->averageSalaryByDepartment();
        if (!$avg) return null;
        arsort($avg);
        $dept = array_key_first($avg);
        return ['department' => (string)$dept, 'average' => (float)$avg[$dept]];
    }

    /** @return array<int,array{name:string,salary:float,department:string}> */
    public function employeesAboveDepartmentAverage(): array
    {
        $avg = $this->averageSalaryByDepartment();
        return array_values(array_filter($this->employees, function ($e) use ($avg) {
            return $e['salary'] > ($avg[$e['department']] ?? INF);
        }));
    }
}