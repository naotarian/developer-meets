import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import axios from 'axios';
import InputField from '../Molecules/InputField';
import InputImageField from '../Molecules/InputImageField';
import SelectField from '../Molecules/SelectField';
import LabelButton from '../Atoms/LabelButton';
import PreviewDialog from '../Molecules/PreviewDialog';
import Notification from '../Atoms/Notification';
import ProgressCircular from '../Molecules/ProgressCircular';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

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

const experienceMap = {
  0: '未経験可',
  1: '~1年',
  2: '~2年',
  3: '~3年',
  4: '4年以上',
};

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

const ProjectEditPage = () => {
  const [submit, setSubmit] = useState(false);
  const [loading, setLoading] = useState(false);
  const [notificationLevel, setNotificationLevel] = useState('');
  const [notificationText, setNotificationText] = useState('');
  const [projectId, setProjectId] = useState(null);
  // 各項目値
  const [title, setTitle] = useState('');
  const [numPeople, setNumPeople] = useState('');
  const [lowerLimit, setLowerLimit] = useState(null);
  const [upperLimit, setUpperLimit] = useState(null);
  const [purpose, setPurpose] = useState('');
  const [gender, setGender] = useState('');
  const [language, setLanguage] = useState('');
  const [subLanguage, setSubLanguage] = useState('');
  const [experience, setExperience] = useState('');
  const [tool, setTool] = useState('');
  const [frequency, setFrequency] = useState('');
  const [projectImage, setProjectImage] = useState(null);
  const [detail, setDetail] = useState('');
  const [remarks, setRemarks] = useState('');
  // 画像クロップ関連値
  const [srcImg, setSrcImg] = useState(null);
  const [fileName, setFileName] = useState('');
  const [openPreviewDialog, setOpenPreviewDialog] = useState(false);

  useEffect(()=> {
    let protocol = location.host === 'developer-meets.com' ? 'https' : 'http';
    let projectId = location.pathname.replace('/project/edit/', '');
    let url = `${protocol}://${location.host}/api/detail/${projectId}`;
    axios.get(url).then(res => {
      if (res.data) {
        let data = res.data;
        if (data.id) { setProjectId(data.id); }
        if (data.project_name) { setTitle(data.project_name); }
        if (data.number_of_application) { setNumPeople(`${data.number_of_application}人`); }
        if (data.minimum_years_old) { setLowerLimit(data.minimum_years_old); }
        if (data.max_years_old) { setUpperLimit(data.max_years_old); }
        if (data.purpose) { setPurpose(data.purpose); }
        if (data.men_and_women) { setGender(data.men_and_women); }
        if (data.language) { setLanguage(data.language); }
        if (data.sub_language) { setSubLanguage(data.sub_language); }
        if (data.minimum_experience) { setExperience(experienceMap[data.minimum_experience]); }
        if (data.tools) { setTool(data.tools); }
        if (data.work_frequency) { setFrequency(data.work_frequency); }
        if (data.project_image) { setFileName(data.project_image); }
        if (data.project_detail) { setDetail(data.project_detail); }
        if (data.remarks) { setRemarks(data.remarks); }
      }
    });
  }, []);

  const pushNotification = (level, text) => {
    setNotificationLevel(level);
    setNotificationText(text);
  };

  const closeNotification = () => {
    setNotificationLevel('');
    setNotificationText('');
  };

  const submitProject = async () => {
    let protocol = location.host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${location.host}/api/edit_project`;
    let d = {
      // プロジェクトID
      'project_id': projectId,
      // プロジェクト名
      'project_name': title,
      // 募集人数
      'number_of_application': numPeople,
      // 主要言語
      'language': language,
      // サブ言語
      'sub_language': subLanguage,
      // ソース管理
      'tools': tool,
      // プロジェクトの目的
      'purpose': purpose,
      // 最低実務経験
      'minimum_experience': experience,
      // 作業頻度
      'work_frequency': frequency,
      // 年齢下限
      'minimum_years_old': lowerLimit,
      // 年齢上限
      'max_years_old': upperLimit,
      // 性別
      'men_and_women': gender,
      // イメージ画像
      'project_image': projectImage,
      // プロジェクト詳細
      'project_detail': detail,
      // 備考
      'remarks': remarks,
    };

    let level;
    let text;
    setLoading(true);
    try {
      setSubmit(true);
      if (!title || !numPeople || !language || !subLanguage || !tool || !purpose || !experience) {
        throw '必須項目を入力してください';
      }
      if (title.length > 50 || detail.length > 1000 || remarks.length > 1000) {
        throw '登録できる文字数超えています';
      }
      await axios.post(url, d).then(res => {
        if (res.data.status_code !== 200) throw 'プロジェクトの編集に失敗しました';
      });
      level = 'success';
      text = 'プロジェクト内容を編集しました';
    } catch (e) {
      level = 'error';
      text = e;
    } finally {
      setLoading(false);
      pushNotification(level, text);
    }
  };

  return (
    <WrapperGrid>
      <PageTitle variant='h4'>プロジェクト編集</PageTitle>
      <InputFormGrid container >
        <InputField label='プロジェクト名' type='text' value={title} onChange={(val) => setTitle(val)} required submit={submit} />
        <SelectField label='募集人数' items={['1人', '2人', '3人',]} value={numPeople} onChange={(val) => setNumPeople(val)} required submit={submit} />
        <SelectField label='主要言語' items={languageList} value={language} onChange={(val) => setLanguage(val)} required submit={submit} />
        <SelectField label='サブ言語' items={languageList} value={subLanguage} onChange={(val) => setSubLanguage(val)} required submit={submit} />
        <SelectField label='ソース管理' items={['GitHub', 'GitLab', 'SVN', 'BitBucket', 'SouceTree', 'その他', 'なし']} value={tool} onChange={(val) => setTool(val)} required submit={submit} />
        <SelectField label='プロジェクトの目的' items={['繋がり', 'リリース', '学習', 'ワイワイ', 'すべて']} value={purpose} onChange={(val) => setPurpose(val)} required submit={submit} />
        <SelectField label='最低実務経験' items={['未経験可', '~1年', '~2年', '~3年', '4年以上']} value={experience} onChange={(val) => setExperience(val)} required submit={submit} />
        <SelectField label='作業頻度' items={['週1~2時間', '週3~4時間', '週1日', '週2~3日', '週4~5日']} value={frequency} onChange={(val) => setFrequency(val)} />
        <InputField label='年齢下限' type='number' value={lowerLimit} onChange={(val) => setLowerLimit(val)} />
        <InputField label='年齢上限' type='number' value={upperLimit} onChange={(val) => setUpperLimit(val)} />
        <SelectField label='性別' items={['制限なし', '男性のみ', '女性のみ']} value={gender} onChange={(val) => setGender(val)} />
        <InputImageField
          label='イメージ画像'
          openDialog={() => setOpenPreviewDialog(true)}
          setSrcImg={(val) => setSrcImg(val)}
          fileName={fileName}
          setFileName={(val) => setFileName(val)}
          deleteProjectImg={() => setProjectImage(null)}
        />
        <InputField label='プロジェクト詳細' type='text' fullWidth multiline value={detail} onChange={(val) => setDetail(val)} />
        <InputField label='備考' type='text' fullWidth multiline value={remarks} onChange={(val) => setRemarks(val)} />
      </InputFormGrid>
      <SubmitButton
        label='この内容で作成する'
        variant='contained'
        color='success'
        size='large'
        onClick={submitProject}
      />
      <PreviewDialog
        open={openPreviewDialog}
        srcImage={srcImg}
        closeDialog={() => setOpenPreviewDialog(false)}
        setProjectImage={(val) => setProjectImage(val)}
      />
      <ProgressCircular loading={loading} />
      <Notification onClose={closeNotification} level={notificationLevel} text={notificationText} />
    </WrapperGrid>
  );
};

export default ProjectEditPage;

ReactDOM.render(<ProjectEditPage />, document.getElementById('project_edit'));