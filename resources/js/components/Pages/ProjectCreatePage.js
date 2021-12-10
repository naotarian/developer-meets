import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
// import axios from 'axios';
import InputField from '../Molecules/InputField';
import LabelButton from '../Atoms/LabelButton';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
// import TextField from '@mui/material/TextField';
// import InputLabel from '@mui/material/InputLabel';
// import MenuItem from '@mui/material/MenuItem';
// import FormControl from '@mui/material/FormControl';
// import Select from '@mui/material/Select';

const languageList = [
  'C',
  'C#',
  'C++',
  'Cantana',
  'COBOL',
  'CoffeeScript',
  'Dart',
  'Go',
  'Java',
  'JavaScript',
  'Kotlin',
  'MQL',
  'Objective',
  'Perl',
  'PHP',
  'PowerShell',
  'Python',
  'Ruby',
  'Rust',
  'Scala',
  'sh',
  'Swift',
  'TypeScript',
  'VBScript',
  'VisualBasic',
  '.NET',
];

const WrapperGrid = styled(Grid)`
  width: 90%;
  margin: auto;
  margin-top: 4rem;
  margin-bottom: 4rem;
`;

const PageTitle = styled(Typography)`
  text-align: center;
`;

const InputFormGrid = styled(Grid)`
  margin-top: 2rem;
`;

const SubmitButton = styled(LabelButton)`
  margin: auto !important;
  display: block !important;
`;

const ProjectCreatePage = () => {
  // const [host, setHost] = useState('');
  const [title, setTitle] = useState('');

  // useEffect(() => {
  //   setHost(location.host);
  // }, []);

  // useEffect(() => {
  //   if (host) {
  //     let protocol = host === 'developer-meets.com' ? 'https' : 'http';
  //     let projectId = location.pathname.replace('/seek/detail/', '');
  //     let url = `${protocol}://${host}/api/detail/${projectId}`;
  //     console.log(url);
  //   }
  // }, [host]);
  return (
    <WrapperGrid>
      <PageTitle variant='h4'>新規プロジェクト作成</PageTitle>
      <InputFormGrid container >
        {/* 必須 */}
        <InputField label='プロジェクト名' value={title} onChange={(val) => setTitle(val)}  />
        {/* 必須 */}
        <InputField select label='募集人数' items={['1人', '2人', '3人',]} />
        <InputField select label='年齢下限' items={[1, 2, 3]} />
        <InputField select label='年齢上限' items={[60, 70, 80]} />
        {/* 必須 */}
        <InputField select label='プロジェクト目的' items={['繋がり', 'リリース', '学習', 'ワイワイ', 'すべて']} />
        <InputField select label='性別' items={['制限なし', '男性のみ', '女性のみ']} />
        {/* 必須 */}
        <InputField select label='主要言語' items={languageList} />
        {/* 必須 */}
        <InputField select label='サブ言語' items={languageList} />
        {/* 必須 */}
        <InputField select label='最低実務経験' items={['未経験可', '~1年', '~2年', '~3年', '4年以上']} />
        {/* 必須 */}
        <InputField select label='ソース管理' items={['GitHub', 'GitLab', 'SVN', 'BitBucket', 'SouceTree', 'その他', 'なし']} />
        <InputField select label='作業頻度' items={['週1~2時間', '週3~4時間', '週1日', '週2~3日', '週4~5日']} />
        {/* 画像選択 */}
        {/* プロジェクト詳細 */}
        <InputField multiline fullWidth label='プロジェクト詳細' />
        {/* 備考 */}
        <InputField multiline fullWidth label='備考' />
      </InputFormGrid>
      <SubmitButton label='この内容で作成する' variant='contained' color="success" size="large" />
    </WrapperGrid>
  );
};

export default ProjectCreatePage;

ReactDOM.render(<ProjectCreatePage />, document.getElementById('project_create'));